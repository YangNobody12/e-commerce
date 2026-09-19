<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // เช็คว่าตารางและ Model ของเพื่อนๆ ในทีมพร้อมใช้งานหรือยัง (เพื่อไม่ให้หน้า Admin พังขณะที่เพื่อนยังทำไม่เสร็จ)
        $hasProducts = class_exists(Product::class) && Schema::hasTable('products');
        $hasCategories = class_exists(Category::class) && Schema::hasTable('categories');
        $hasOrders = class_exists(Order::class) && Schema::hasTable('orders');

        $stats = [
            'total_users' => User::count(),
            'total_products' => $hasProducts ? Product::count() : 0,
            'total_orders' => $hasOrders ? Order::count() : 0,
            'total_categories' => $hasCategories ? Category::count() : 0,
            'total_revenue' => $hasOrders ? Order::where('status', '!=', 'cancelled')->sum('total_amount') : 0,
            'pending_orders' => $hasOrders ? Order::where('status', 'pending')->count() : 0,
            'recent_orders' => $hasOrders ? Order::with('user')->latest()->take(5)->get() : collect(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}