# 🛒 คู่มือสำหรับ กวาง (Cart & Order System)

## 📋 งานของกวาง
- สร้าง Migration ตาราง `carts`, `orders`, `order_items`
- สร้าง Model: Cart, Order, OrderItem
- ระบบตะกร้าสินค้า (เพิ่ม/ลบ/แก้จำนวน)
- ระบบสั่งซื้อ (Checkout)
- หน้าประวัติคำสั่งซื้อ
- จัดการคำสั่งซื้อ (Admin - อัพเดทสถานะ)

---

## 🔧 ขั้นตอนที่ 1: ติดตั้งเครื่องมือที่จำเป็น

### 1.1 ติดตั้ง Git

**สำหรับ Windows:**
1. ไปที่ https://git-scm.com/download/win
2. ดาวน์โหลดและติดตั้ง (กด Next ไปเรื่อยๆ)
3. เปิด **Git Bash** หรือ **Command Prompt**

**สำหรับ macOS:**
```bash
brew install git
```

**ตรวจสอบว่าติดตั้งสำเร็จ:**
```bash
git --version
```

### 1.2 ตั้งค่า Git (ทำครั้งเดียว)
```bash
git config --global user.name "กวาง"
git config --global user.email "kwang-email@example.com"
```

### 1.3 ติดตั้ง PHP & Composer

**Windows:**
1. ดาวน์โหลด PHP จาก https://windows.php.net/download
2. ดาวน์โหลด Composer จาก https://getcomposer.org/download/

**macOS:**
```bash
brew install php
brew install composer
```

### 1.4 ติดตั้ง Node.js
ไปที่ https://nodejs.org/ ดาวน์โหลด **LTS version**

### 1.5 ติดตั้ง Code Editor
แนะนำ **Visual Studio Code** → https://code.visualstudio.com/

---

## 📥 ขั้นตอนที่ 2: ดึงโค้ดจาก GitHub

### 2.1 Clone โปรเจกต์
```bash
git clone https://github.com/YangNobody12/e-commerce.git
cd e-commerce
```

### 2.2 เปิดโปรเจกต์ใน VS Code & เปิด Terminal
- **วิธีที่ 1 (ผ่าน Terminal):** พิมพ์คำสั่ง `code .` แล้วกด Enter
- **วิธีที่ 2 (ผ่านโปรแกรม):** เปิดโปรแกรม VS Code ➔ **File** > **Open Folder...** (macOS: **Open...**) ➔ เลือกโฟลเดอร์ `e-commerce`

> 🖥️ **วิธีเปิด Terminal ใน VS Code:**  
> ไปที่เมนู **Terminal** > **New Terminal** (หรือกดคีย์ลัด: ``Ctrl + ` `` สำหรับ Windows หรือ ``Cmd + ` `` สำหรับ macOS)  
> แล้วรันคำสั่งทั้งหมดต่อจากนี้ใน Terminal ของ VS Code ได้เลย!

### 2.3 สลับไปยัง Branch ของกวาง
```bash
# รันใน Terminal ของ VS Code:
# สร้างและสลับไปที่ branch ของกวาง (ใช้ -b เพื่อสร้าง branch ใหม่ทันที)
git checkout -b feature/cart-orders

# ตรวจสอบว่าอยู่ถูก branch
git branch
# ควรเห็น: * feature/cart-orders (มีดอกจันสีเขียวอยู่ข้างหน้า)
```

> 💡 **หมายเหตุเรื่องคำสั่ง Git:**  
> - ถ้าใช้ `git checkout feature/cart-orders` (ไม่มี `-b`) แล้วขึ้นสีแดงว่า:  
>   `error: pathspec 'feature/cart-orders' did not match any file(s) known to git`  
>   แสดงว่าบน GitHub ยังไม่มี branch นี้ **ให้เติม `-b` เป็น `git checkout -b feature/cart-orders`** เพื่อสร้าง branch บนเครื่องตัวเองได้ทันทีเลยครับ!

### 2.4 ติดตั้ง Dependencies
```bash
composer install
npm install

# คัดลอก .env (แก้ตามที่หยางส่งมา)
cp .env.example .env
# ⚠️ แก้ไข .env ตามที่หยางส่งมาทาง Line/Discord

php artisan key:generate
```

### 2.5 ทดสอบ
```bash
php artisan serve
# เปิด http://localhost:8000
```

---

## 💻 ขั้นตอนที่ 3: เริ่มเขียนโค้ด

### 3.1 สร้าง Migration

#### Migration สำหรับ Carts
```bash
php artisan make:migration create_carts_table
```

แก้ไข migration:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // ป้องกันสินค้าซ้ำในตะกร้า
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
```

#### Migration สำหรับ Orders
```bash
php artisan make:migration create_orders_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number', 50)->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending');
            $table->string('shipping_name');
            $table->text('shipping_address');
            $table->string('shipping_phone', 20);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
```

#### Migration สำหรับ Order Items
```bash
php artisan make:migration create_order_items_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
```

#### รัน Migration

> ⚠️ **ข้อควรระวังเรื่องลำดับ:** ตาราง `carts` และ `order_items` มี Foreign Key เชื่อมไปยังตาราง `products` ของโชค  
> - ดังนั้นตาราง `products` ต้องถูกสร้างบน Supabase ก่อน (โชคต้องรัน migrate แล้ว)  
> - ถ้าโชครัน migrate แล้ว กวางสามารถรันคำสั่งด้านล่างได้ทันที:

```bash
php artisan migrate
```

### 3.2 สร้าง Models

#### Model Cart
```bash
php artisan make:model Cart
```

แก้ไข `app/Models/Cart.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // คำนวณราคารวมของ item นี้
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}
```

#### Model Order
```bash
php artisan make:model Order
```

แก้ไข `app/Models/Order.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_name',
        'shipping_address',
        'shipping_phone',
        'note',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // สร้างเลขที่คำสั่งซื้ออัตโนมัติ เช่น ORD-20260919-001
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $lastOrder = self::where('order_number', 'like', "ORD-{$date}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "ORD-{$date}-{$newNumber}";
    }

    // แปลงสถานะเป็นภาษาไทย
    public function getStatusThaiAttribute(): string
    {
        return match($this->status) {
            'pending' => 'รอดำเนินการ',
            'processing' => 'กำลังดำเนินการ',
            'shipped' => 'จัดส่งแล้ว',
            'delivered' => 'ส่งถึงแล้ว',
            'cancelled' => 'ยกเลิก',
            default => $this->status,
        };
    }

    // สีของ badge ตามสถานะ
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
```

#### Model OrderItem
```bash
php artisan make:model OrderItem
```

แก้ไข `app/Models/OrderItem.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### 3.3 สร้าง Controllers

#### CartController
```bash
php artisan make:controller CartController
```

แก้ไข `app/Http/Controllers/CartController.php`:
```php
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
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
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
            return back()->with('error', 'สินค้าในสต็อกไม่เพียงพอ');
        }

        // ถ้ามีในตะกร้าแล้ว ให้เพิ่มจำนวน
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'เพิ่มสินค้าลงตะกร้าแล้ว!');
    }

    // อัพเดทจำนวนสินค้าในตะกร้า
    public function update(Request $request, Cart $cart)
    {
        // ตรวจสอบว่าเป็นตะกร้าของผู้ใช้คนนี้
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // ตรวจสอบสต็อก
        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'สินค้าในสต็อกไม่เพียงพอ');
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
```

#### OrderController
```bash
php artisan make:controller OrderController
```

แก้ไข `app/Http/Controllers/OrderController.php`:
```php
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
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'ตะกร้าว่างเปล่า กรุณาเพิ่มสินค้าก่อน');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
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

        // ใช้ DB Transaction เพื่อความปลอดภัย
        DB::transaction(function () use ($request, $cartItems) {
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

        return redirect()->route('orders.index')
            ->with('success', 'สั่งซื้อสำเร็จ!');
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
        // ตรวจสอบว่าเป็นคำสั่งซื้อของผู้ใช้คนนี้
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');

        return view('orders.show', compact('order'));
    }
}
```

#### Admin OrderController (จัดการคำสั่งซื้อ)
```bash
php artisan make:controller Admin/OrderController
```

แก้ไข `app/Http/Controllers/Admin/OrderController.php`:
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'อัพเดทสถานะคำสั่งซื้อแล้ว');
    }
}
```

### 3.4 สร้าง Views

#### หน้าตะกร้าสินค้า
สร้างไฟล์ `resources/views/cart/index.blade.php`:
```html
@extends('layouts.app')

@section('title', 'ตะกร้าสินค้า')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart3"></i> ตะกร้าสินค้า</h2>

    @if($cartItems->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>ราคา</th>
                            <th style="width: 150px;">จำนวน</th>
                            <th>รวม</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->product->image)
                                        <img src="{{ asset($item->product->image) }}" width="60" height="60" 
                                             class="rounded me-3" style="object-fit: cover;">
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                        <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>฿{{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                           min="1" class="form-control form-control-sm" style="width: 70px;"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="fw-bold text-danger">
                                ฿{{ number_format($item->quantity * $item->product->price, 2) }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- สรุปยอด --}}
        <div class="row mt-4">
            <div class="col-md-4 ms-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>สรุปคำสั่งซื้อ</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>จำนวนสินค้า:</span>
                            <span>{{ $cartItems->sum('quantity') }} ชิ้น</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">ยอดรวม:</span>
                            <span class="fw-bold fs-5 text-danger">฿{{ number_format($total, 2) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-add-cart w-100">
                            <i class="bi bi-credit-card"></i> ดำเนินการสั่งซื้อ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
            <h4 class="mt-3 text-muted">ตะกร้าว่างเปล่า</h4>
            <a href="{{ url('/shop') }}" class="btn btn-primary mt-3">เลือกซื้อสินค้า</a>
        </div>
    @endif
</div>
@endsection
```

#### หน้า Checkout
สร้างไฟล์ `resources/views/cart/checkout.blade.php`:
```html
@extends('layouts.app')

@section('title', 'ชำระเงิน')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-credit-card"></i> ชำระเงิน</h2>

    <form action="{{ route('orders.place') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- ข้อมูลจัดส่ง --}}
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">ข้อมูลการจัดส่ง</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ชื่อผู้รับ <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                   value="{{ old('shipping_name', auth()->user()->name) }}" required>
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                            <input type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                   value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ที่อยู่จัดส่ง <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                      rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">หมายเหตุ</label>
                            <textarea name="note" class="form-control" rows="2" 
                                      placeholder="เช่น ส่งช่วงเย็น, วางไว้หน้าบ้าน">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- สรุปคำสั่งซื้อ --}}
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">สรุปคำสั่งซื้อ</h5>

                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                            <span>฿{{ number_format($item->quantity * $item->product->price, 2) }}</span>
                        </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">ยอดรวมทั้งหมด:</span>
                            <span class="fw-bold fs-5 text-danger">฿{{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-add-cart w-100 btn-lg" 
                                onclick="return confirm('ยืนยันการสั่งซื้อ?')">
                            <i class="bi bi-check-circle"></i> ยืนยันสั่งซื้อ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
```

#### หน้าประวัติคำสั่งซื้อ
สร้างไฟล์ `resources/views/orders/index.blade.php`:
```html
@extends('layouts.app')

@section('title', 'ประวัติคำสั่งซื้อ')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-receipt"></i> ประวัติคำสั่งซื้อ</h2>

    @forelse($orders as $order)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $order->order_number }}</h5>
                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-{{ $order->status_color }} mb-2">{{ $order->status_thai }}</span>
                    <br>
                    <span class="fw-bold text-danger fs-5">฿{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            <hr>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                ดูรายละเอียด <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="bi bi-receipt-cutoff" style="font-size: 4rem; color: #ccc;"></i>
        <h4 class="mt-3 text-muted">ยังไม่มีคำสั่งซื้อ</h4>
        <a href="{{ url('/shop') }}" class="btn btn-primary mt-3">เลือกซื้อสินค้า</a>
    </div>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection
```

#### หน้ารายละเอียดคำสั่งซื้อ
สร้างไฟล์ `resources/views/orders/show.blade.php`:
```html
@extends('layouts.app')

@section('title', 'คำสั่งซื้อ ' . $order->order_number)

@section('content')
<div class="container py-5">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>คำสั่งซื้อ: {{ $order->order_number }}</h3>
                <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_thai }}</span>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">ข้อมูลจัดส่ง</h6>
                    <p>
                        <strong>ชื่อ:</strong> {{ $order->shipping_name }}<br>
                        <strong>โทร:</strong> {{ $order->shipping_phone }}<br>
                        <strong>ที่อยู่:</strong> {{ $order->shipping_address }}
                    </p>
                    @if($order->note)
                        <p><strong>หมายเหตุ:</strong> {{ $order->note }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="text-muted">วันที่สั่งซื้อ</h6>
                    <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>สินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th class="text-end">รวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>฿{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end">฿{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold fs-5">ยอดรวมทั้งหมด:</td>
                        <td class="text-end fw-bold fs-5 text-danger">฿{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
```

#### หน้าจัดการคำสั่งซื้อ (Admin)
สร้างไฟล์ `resources/views/admin/orders/index.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'จัดการคำสั่งซื้อ')

@section('content')
<h2 class="mb-4"><i class="bi bi-receipt"></i> จัดการคำสั่งซื้อ</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>เลขที่</th>
                    <th>ลูกค้า</th>
                    <th>ยอดรวม</th>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td class="text-danger fw-bold">฿{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>กำลังดำเนินการ</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>จัดส่งแล้ว</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>ส่งถึงแล้ว</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">ยังไม่มีคำสั่งซื้อ</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</div>
@endsection
```

### 3.5 เพิ่ม Routes

เพิ่มใน `routes/web.php`:
```php
// ============================================
// 🛒 ตะกร้า & คำสั่งซื้อ (กวาง)
// ============================================
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::middleware(['auth'])->group(function () {
    // ตะกร้า
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin - จัดการคำสั่งซื้อ
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
```

---

## 📤 ขั้นตอนที่ 4: Commit & Push โค้ด

```bash
# ดูไฟล์ที่เปลี่ยนแปลง
git status

# เพิ่มไฟล์ทั้งหมด
git add .

# Commit
git commit -m "feat: ระบบตะกร้าสินค้า, สั่งซื้อ, ประวัติคำสั่งซื้อ"

# Push ขึ้น GitHub
git push origin feature/cart-orders
```

---

## ✅ Checklist ของกวาง

- [ ] ติดตั้ง Git, PHP, Composer, Node.js, VS Code
- [ ] Clone โปรเจกต์ & สลับ branch `feature/cart-orders`
- [ ] ติดตั้ง dependencies & ตั้งค่า .env
- [ ] สร้าง Migration: carts, orders, order_items
- [ ] สร้าง Model: Cart, Order, OrderItem
- [ ] สร้าง CartController (เพิ่ม/ลบ/แก้จำนวนในตะกร้า)
- [ ] สร้าง OrderController (Checkout, สร้างคำสั่งซื้อ, ประวัติ)
- [ ] สร้าง Admin OrderController (จัดการสถานะ)
- [ ] สร้าง Views: cart (index, checkout)
- [ ] สร้าง Views: orders (index, show)
- [ ] สร้าง Views: admin orders (index)
- [ ] เพิ่ม Routes
- [ ] ทดสอบว่าทำงานได้
- [ ] Commit & Push ขึ้น GitHub
- [ ] แจ้งหยางว่าทำเสร็จแล้ว

---

## 🆘 แก้ปัญหาเบื้องต้น

| ปัญหา | วิธีแก้ |
|---|---|
| Migration error: table products doesn't exist | ต้องรันหลังจากที่โชคสร้าง products table แล้ว หรือสร้าง migration ที่มีวันที่หลัง products |
| `Class Product not found` | ตรวจสอบว่ามีไฟล์ `app/Models/Product.php` (โชคต้องทำก่อน) |
| Cart ซ้ำ | มี unique constraint แล้ว ถ้าเพิ่มซ้ำจะ update quantity แทน |
| `git push` ไม่ได้ | `git pull origin feature/cart-orders` ก่อน แล้ว push ใหม่ |
