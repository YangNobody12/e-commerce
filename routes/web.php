<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
    // จัดการสินค้า & หมวดหมู่ (โชค)
    // จัดการคำสั่งซื้อ (กวาง)

