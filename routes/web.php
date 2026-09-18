<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// 🏠 หน้าแรก (พลับ)
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// 🔐 Auth Routes (หยาง) - มาจาก Breeze อัตโนมัติ
// ============================================
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================
// 👤 โปรไฟล์ (ปิงปอง)
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// 🛒 ตะกร้า & คำสั่งซื้อ (กวาง - เพิ่มในกลุ่มนี้)
// ============================================
// Route::middleware(['auth'])->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// });

// ============================================
// ⚙️ Admin Routes (โชค / ปิงปอง / กวาง)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard (ปิงปอง)
    // จัดการสินค้า & หมวดหมู่ (โชค)
    // จัดการคำสั่งซื้อ (กวาง)
});
