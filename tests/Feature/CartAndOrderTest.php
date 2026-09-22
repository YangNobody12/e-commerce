<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndOrderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private Category $category;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $this->category = Category::create([
            'name' => 'เสื้อผ้า',
            'slug' => 'clothes',
            'description' => 'หมวดหมู่เสื้อผ้า',
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'เสื้อยืดทดสอบ',
            'slug' => 'test-t-shirt',
            'price' => 300.00,
            'stock' => 10,
            'description' => 'เสื้อยืดใส่สบาย',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_when_accessing_cart(): void
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }

    public function test_user_can_view_cart_page(): void
    {
        $response = $this->actingAs($this->user)->get('/cart');
        $response->assertOk();
    }

    public function test_user_can_add_product_to_cart(): void
    {
        $response = $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('carts', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_update_cart_item_quantity(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->patch("/cart/{$cart->id}", [
            'quantity' => 5,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(5, $cart->fresh()->quantity);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->delete("/cart/{$cart->id}");
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    public function test_user_can_checkout_and_place_order(): void
    {
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $checkoutResponse = $this->actingAs($this->user)->get('/checkout');
        $checkoutResponse->assertOk();

        $placeOrderResponse = $this->actingAs($this->user)->post('/orders/place', [
            'shipping_name' => 'ผู้รับทดสอบ',
            'shipping_phone' => '0899999999',
            'shipping_address' => '99/9 หมู่ 9 เชียงใหม่',
            'note' => 'ส่งด่วน',
        ]);

        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals(600.00, $order->total_amount);
        $this->assertEquals('pending', $order->status);

        // ตรวจสอบ Order Items
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'subtotal' => 600.00,
        ]);

        // ตรวจสอบว่าสินค้าในตะกร้าถูกลบออก
        $this->assertDatabaseMissing('carts', [
            'user_id' => $this->user->id,
        ]);

        // ตรวจสอบว่าสต็อกถูกหัก
        $this->assertEquals(8, $this->product->fresh()->stock);

        $placeOrderResponse->assertRedirect(route('orders.show', $order));
    }

    public function test_user_can_view_order_history_and_details(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => 300.00,
            'status' => 'pending',
            'shipping_name' => 'ผู้รับ',
            'shipping_phone' => '0812345678',
            'shipping_address' => 'เชียงใหม่',
        ]);

        $responseIndex = $this->actingAs($this->user)->get('/orders');
        $responseIndex->assertOk();
        $responseIndex->assertSee($order->order_number);

        $responseShow = $this->actingAs($this->user)->get("/orders/{$order->id}");
        $responseShow->assertOk();
        $responseShow->assertSee($order->order_number);
    }

    public function test_admin_can_view_orders_and_update_status(): void
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => 300.00,
            'status' => 'pending',
            'shipping_name' => 'ลูกค้า',
            'shipping_phone' => '0812345678',
            'shipping_address' => 'เชียงใหม่',
        ]);

        $adminIndex = $this->actingAs($this->admin)->get('/admin/orders');
        $adminIndex->assertOk();
        $adminIndex->assertSee($order->order_number);

        $adminShow = $this->actingAs($this->admin)->get("/admin/orders/{$order->id}");
        $adminShow->assertOk();

        $updateStatus = $this->actingAs($this->admin)->patch("/admin/orders/{$order->id}/status", [
            'status' => 'shipped',
        ]);

        $updateStatus->assertSessionHas('success');
        $this->assertEquals('shipped', $order->fresh()->status);
    }
}
