<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // แสดงตะกร้าสินค้า
    public function index()
    {
        $cartItems = Cart::with(['product.category'])
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->price ?? 0);
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // เพิ่มสินค้าลงตะกร้า
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // ตรวจสอบสต็อก
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'สินค้าในสต็อกไม่เพียงพอ (คงเหลือ ' . $product->stock . ' ชิ้น)');
        }

        // ถ้ามีในตะกร้าแล้ว ให้เพิ่มจำนวน
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'ไม่สามารถเพิ่มจำนวนได้ สินค้าในสต็อกคงเหลือ ' . $product->stock . ' ชิ้น');
            }
            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'เพิ่ม ' . $product->name . ' ลงตะกร้าแล้ว!');
    }

    // อัพเดทจำนวนสินค้าในตะกร้า
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'สินค้าในสต็อกไม่เพียงพอ (คงเหลือ ' . $cart->product->stock . ' ชิ้น)');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'อัพเดทจำนวนแล้ว');
    }

    // ลบสินค้าจากตะกร้า
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'ลบสินค้าจากตะกร้าแล้ว');
    }
}
