<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // หน้า Checkout
    public function checkout()
    {
        $cartItems = Cart::with(['product.category'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'ตะกร้าว่างเปล่า กรุณาเพิ่มสินค้าก่อน');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->price ?? 0);
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    // สร้างคำสั่งซื้อ
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string|max:20',
            'note' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'ตะกร้าว่างเปล่า');
        }

        // ตรวจสอบสต็อกสินค้าทุกชิ้นก่อนสั่งซื้อ
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "สินค้า {$item->product->name} มีสต็อกไม่เพียงพอ (คงเหลือ {$item->product->stock} ชิ้น)");
            }
        }

        $order = null;

        // ใช้ DB Transaction เพื่อความปลอดภัย
        DB::transaction(function () use ($request, $cartItems, &$order) {
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // สร้าง Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'note' => $request->note,
            ]);

            // สร้าง Order Items & ลดสต็อก
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);

                // ลดสต็อก
                $item->product->decrement('stock', $item->quantity);
            }

            // ลบสินค้าในตะกร้า
            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'สั่งซื้อสำเร็จ! เลขที่คำสั่งซื้อของคุณคือ ' . $order->order_number);
    }

    // ดูประวัติคำสั่งซื้อ
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // ดูรายละเอียดคำสั่งซื้อ
    public function show(Order $order)
    {
        // ตรวจสอบว่าเป็นคำสั่งซื้อของผู้ใช้คนนี้ หรือเป็น Admin
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load(['items.product', 'user']);

        return view('orders.show', compact('order'));
    }
}
