# 🎨 คู่มือสำหรับ พลับ (Frontend Developer)

## 📋 งานของพลับ
- ออกแบบ Layout หลักของเว็บ (Navbar, Footer)
- หน้าแรก (Home Page)
- หน้ารายการสินค้า (Shop Page)
- หน้ารายละเอียดสินค้า (Product Detail)
- CSS / Styling ทั้งหมด

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
# ควรเห็น: git version 2.x.x
```

### 1.2 ตั้งค่า Git (ทำครั้งเดียว)
```bash
git config --global user.name "พลับ"
git config --global user.email "plub-email@example.com"
```

### 1.3 ติดตั้ง PHP & Composer

**Windows:**
1. ดาวน์โหลด PHP จาก https://windows.php.net/download (เลือก VS17 x64 Thread Safe)
2. แตกไฟล์ไว้ที่ `C:\php`
3. เพิ่ม `C:\php` เข้า System PATH
4. ดาวน์โหลด Composer จาก https://getcomposer.org/download/

**macOS:**
```bash
brew install php
brew install composer
```

**ตรวจสอบ:**
```bash
php --version
composer --version
```

### 1.4 ติดตั้ง Node.js & NPM
1. ไปที่ https://nodejs.org/
2. ดาวน์โหลด **LTS version**
3. ติดตั้งแบบปกติ

```bash
node --version
npm --version
```

### 1.5 ติดตั้ง Code Editor
แนะนำ **Visual Studio Code** → https://code.visualstudio.com/

---

## 📥 ขั้นตอนที่ 2: ดึงโค้ดจาก GitHub

### 2.1 Clone โปรเจกต์
```bash
# เปิด Terminal / Git Bash
# ไปยังโฟลเดอร์ที่ต้องการเก็บโปรเจกต์

# Clone repo
git clone https://github.com/YangNobody12/e-commerce.git

# เข้าไปในโฟลเดอร์โปรเจกต์
cd e-commerce
```

### 2.2 เปิดโปรเจกต์ใน VS Code & เปิด Terminal
- **วิธีที่ 1 (ผ่าน Terminal):** พิมพ์คำสั่ง `code .` แล้วกด Enter
- **วิธีที่ 2 (ผ่านโปรแกรม):** เปิดโปรแกรม VS Code ➔ **File** > **Open Folder...** (macOS: **Open...**) ➔ เลือกโฟลเดอร์ `e-commerce`

> 🖥️ **วิธีเปิด Terminal ใน VS Code:**  
> ไปที่เมนู **Terminal** > **New Terminal** (หรือกดคีย์ลัด: ``Ctrl + ` `` สำหรับ Windows หรือ ``Cmd + ` `` สำหรับ macOS)  
> แล้วรันคำสั่งทั้งหมดต่อจากนี้ใน Terminal ของ VS Code ได้เลย!

### 2.3 สลับไปยัง Branch ของพลับ
```bash
# รันใน Terminal ของ VS Code:
# สร้างและสลับไปที่ branch ของพลับ (ใช้ -b เพื่อสร้าง branch ใหม่ทันที)
git checkout -b feature/frontend

# ตรวจสอบว่าอยู่ถูก branch
git branch
# ควรเห็น: * feature/frontend (มีดอกจันสีเขียวอยู่ข้างหน้า)
```

> 💡 **หมายเหตุเรื่องคำสั่ง Git:**  
> - ถ้าใช้ `git checkout feature/frontend` (ไม่มี `-b`) แล้วขึ้นสีแดงว่า:  
>   `error: pathspec 'feature/frontend' did not match any file(s) known to git`  
>   แสดงว่าบน GitHub ยังไม่มี branch นี้ **ให้เติม `-b` เป็น `git checkout -b feature/frontend`** เพื่อสร้าง branch บนเครื่องตัวเองได้ทันทีเลยครับ!

### 2.4 ติดตั้ง Dependencies
```bash
# ติดตั้ง PHP packages
composer install

# ติดตั้ง JavaScript packages
npm install

# คัดลอกไฟล์ .env (หยางจะส่งให้ทาง Line/Discord)
cp .env.example .env

# ⚠️ แก้ไขไฟล์ .env ตามที่หยางส่งมา (ใส่ database credentials)

# สร้าง app key
php artisan key:generate
```

### 2.5 ทดสอบว่าโปรเจกต์ทำงานได้
```bash
# เปิด terminal 2 อัน

# Terminal 1: รัน Laravel server
php artisan serve

# Terminal 2: รัน Vite (สำหรับ CSS/JS hot reload)
npm run dev

# เปิดเบราว์เซอร์ไปที่ http://localhost:8000
```

---

## 💻 ขั้นตอนที่ 3: เริ่มเขียนโค้ด

### 3.1 สร้าง Layout หลัก

สร้างไฟล์ `resources/views/layouts/app.blade.php`:
```html
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Shop')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-shop"></i> E-Commerce
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/shop') }}">สินค้า</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/cart') }}">
                                <i class="bi bi-cart3"></i> ตะกร้า
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/profile') }}">โปรไฟล์</a></li>
                                <li><a class="dropdown-item" href="{{ url('/orders') }}">คำสั่งซื้อ</a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin') }}">แผงควบคุม Admin</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">ออกจากระบบ</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">สมัครสมาชิก</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main>
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-shop"></i> E-Commerce</h5>
                    <p class="text-muted">ร้านค้าออนไลน์คุณภาพ สินค้าดี ราคาถูก</p>
                </div>
                <div class="col-md-4">
                    <h5>ลิงก์</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-muted text-decoration-none">หน้าแรก</a></li>
                        <li><a href="{{ url('/shop') }}" class="text-muted text-decoration-none">สินค้า</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>ติดต่อเรา</h5>
                    <p class="text-muted">
                        <i class="bi bi-envelope"></i> contact@example.com<br>
                        <i class="bi bi-telephone"></i> 02-xxx-xxxx
                    </p>
                </div>
            </div>
            <hr>
            <p class="text-center text-muted mb-0">&copy; 2026 E-Commerce. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

### 3.2 สร้าง Custom CSS

สร้างไฟล์ `public/css/style.css`:
```css
/* ============================================
   Custom Styles - E-Commerce
   ============================================ */

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0;
    color: white;
}

.hero-section h1 {
    font-size: 3rem;
    font-weight: 700;
}

/* Product Cards */
.product-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-card .card-img-top {
    height: 220px;
    object-fit: cover;
}

.product-card .card-body {
    padding: 20px;
}

.product-card .product-price {
    color: #e74c3c;
    font-size: 1.3rem;
    font-weight: 700;
}

/* Category Cards */
.category-card {
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: scale(1.03);
}

.category-card img {
    height: 200px;
    object-fit: cover;
    width: 100%;
}

.category-card .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    padding: 20px;
    color: white;
}

/* Buttons */
.btn-add-cart {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: opacity 0.3s ease;
}

.btn-add-cart:hover {
    opacity: 0.9;
    color: white;
}

/* Section Titles */
.section-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

/* Admin Layout */
.admin-sidebar {
    min-height: 100vh;
    background: #2c3e50;
}

.admin-sidebar .nav-link {
    color: rgba(255, 255, 255, 0.7);
    padding: 12px 20px;
    border-radius: 8px;
    margin: 2px 10px;
}

.admin-sidebar .nav-link:hover,
.admin-sidebar .nav-link.active {
    color: white;
    background: rgba(255, 255, 255, 0.1);
}
```

### 3.3 สร้าง Controller
```bash
php artisan make:controller HomeController
php artisan make:controller ShopController
```

แก้ไข `app/Http/Controllers/HomeController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // TODO: ดึงสินค้าแนะนำ & หมวดหมู่จาก database
        // ตอนนี้ใช้ข้อมูลจำลองก่อน
        return view('home');
    }
}
```

แก้ไข `app/Http/Controllers/ShopController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // TODO: ดึงสินค้าจาก database พร้อม pagination & filter
        return view('shop.index');
    }

    public function show($slug)
    {
        // TODO: ดึงข้อมูลสินค้าจาก database
        return view('shop.show');
    }
}
```

### 3.4 สร้าง Views

สร้างไฟล์ `resources/views/home.blade.php`:
```html
@extends('layouts.app')

@section('title', 'หน้าแรก - E-Commerce')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section text-center">
        <div class="container">
            <h1>ยินดีต้อนรับสู่ร้านค้าออนไลน์</h1>
            <p class="lead mt-3">สินค้าคุณภาพ ราคาดี จัดส่งรวดเร็ว</p>
            <a href="{{ url('/shop') }}" class="btn btn-light btn-lg mt-3 px-5 rounded-pill">
                <i class="bi bi-bag"></i> เลือกซื้อสินค้า
            </a>
        </div>
    </section>

    {{-- หมวดหมู่สินค้า --}}
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">หมวดหมู่สินค้า</h2>
            <div class="row g-4 mt-2">
                {{-- TODO: Loop จาก database --}}
                <div class="col-md-3">
                    <div class="category-card">
                        <img src="https://via.placeholder.com/400x200" alt="หมวดหมู่">
                        <div class="overlay">
                            <h5 class="mb-0">เสื้อผ้า</h5>
                        </div>
                    </div>
                </div>
                <!-- เพิ่มหมวดหมู่อื่นๆ -->
            </div>
        </div>
    </section>

    {{-- สินค้าแนะนำ --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">สินค้าแนะนำ</h2>
            <div class="row g-4 mt-2">
                {{-- TODO: Loop จาก database --}}
                <div class="col-md-3">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="สินค้า">
                        <div class="card-body">
                            <h5 class="card-title">ชื่อสินค้า</h5>
                            <p class="product-price">฿ 999</p>
                            <a href="#" class="btn btn-add-cart w-100">
                                <i class="bi bi-cart-plus"></i> เพิ่มลงตะกร้า
                            </a>
                        </div>
                    </div>
                </div>
                <!-- เพิ่มสินค้าอื่นๆ -->
            </div>
        </div>
    </section>
@endsection
```

สร้างไฟล์ `resources/views/shop/index.blade.php`:
```html
@extends('layouts.app')

@section('title', 'สินค้าทั้งหมด - E-Commerce')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar: Filter --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">กรองสินค้า</h5>
                    <hr>
                    <h6>หมวดหมู่</h6>
                    <ul class="list-unstyled">
                        {{-- TODO: Loop จาก categories --}}
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-dark">เสื้อผ้า (10)</a>
                        </li>
                    </ul>
                    
                    <hr>
                    <h6>ช่วงราคา</h6>
                    <form>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="ต่ำสุด" name="min_price">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="สูงสุด" name="max_price">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark w-100 mt-2">กรอง</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">สินค้าทั้งหมด</h2>
                <select class="form-select w-auto">
                    <option>เรียงตาม: ล่าสุด</option>
                    <option>ราคา: ต่ำ → สูง</option>
                    <option>ราคา: สูง → ต่ำ</option>
                    <option>ชื่อ: ก → ฮ</option>
                </select>
            </div>

            <div class="row g-4">
                {{-- TODO: Loop จาก products --}}
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="สินค้า">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">หมวดหมู่</span>
                            <h5 class="card-title">ชื่อสินค้า</h5>
                            <p class="product-price">฿ 999</p>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-dark flex-fill">ดูรายละเอียด</a>
                                <button class="btn btn-add-cart">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- เพิ่มสินค้าอื่นๆ -->
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{-- TODO: {{ $products->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
```

สร้างไฟล์ `resources/views/shop/show.blade.php`:
```html
@extends('layouts.app')

@section('title', 'รายละเอียดสินค้า - E-Commerce')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/shop') }}">สินค้า</a></li>
            <li class="breadcrumb-item active">ชื่อสินค้า</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- รูปสินค้า --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/600x500" class="card-img-top" alt="สินค้า">
            </div>
        </div>

        {{-- ข้อมูลสินค้า --}}
        <div class="col-md-6">
            <span class="badge bg-secondary mb-2">หมวดหมู่</span>
            <h1 class="fw-bold">ชื่อสินค้า</h1>
            <p class="product-price fs-2">฿ 999</p>
            
            <div class="mb-3">
                <span class="badge bg-success">มีสินค้า (50 ชิ้น)</span>
            </div>

            <p class="text-muted">
                รายละเอียดสินค้า... Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </p>

            <hr>

            <form action="#" method="POST">
                @csrf
                <div class="d-flex align-items-center gap-3 mb-4">
                    <label class="fw-bold">จำนวน:</label>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">-</button>
                        <input type="number" class="form-control text-center" name="quantity" value="1" min="1" id="qty">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-add-cart btn-lg w-100">
                    <i class="bi bi-cart-plus"></i> เพิ่มลงตะกร้า
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}
function decreaseQty() {
    let qty = document.getElementById('qty');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
@endpush
```

### 3.5 เพิ่ม Routes ในไฟล์ `routes/web.php`
เพิ่มใน section ของพลับ:
```php
// ============================================
// 🏠 หน้าแรก & 🏪 หน้าร้าน (พลับ)
// ============================================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
```

---

## 📤 ขั้นตอนที่ 4: Commit & Push โค้ด

### 4.1 ตรวจสอบไฟล์ที่เปลี่ยนแปลง
```bash
# ดูว่ามีไฟล์อะไรเปลี่ยนบ้าง
git status
```

### 4.2 เพิ่มไฟล์เข้า Staging
```bash
# เพิ่มทุกไฟล์
git add .

# หรือเพิ่มเฉพาะไฟล์ที่ต้องการ
git add resources/views/layouts/app.blade.php
git add public/css/style.css
```

### 4.3 Commit (บันทึกการเปลี่ยนแปลง)
```bash
git commit -m "feat: สร้าง Layout หลัก Navbar และ Footer"
```

> 💡 **เทคนิคการเขียน Commit Message:**
> - `feat:` = เพิ่มฟีเจอร์ใหม่
> - `fix:` = แก้บั๊ก
> - `style:` = แก้ CSS/UI
> - `refactor:` = ปรับปรุงโค้ด
> - ตัวอย่าง: `feat: สร้างหน้า Home Page`, `style: ปรับ CSS product card`

### 4.4 Push ขึ้น GitHub
```bash
git push origin feature/frontend
```

### 4.5 ขั้นตอนการทำงานในแต่ละวัน
```bash
# 1. ดึงโค้ดล่าสุดก่อนเริ่มทำงาน
git pull origin feature/frontend

# 2. เขียนโค้ด...

# 3. ทดสอบว่าทำงานได้
php artisan serve

# 4. ดูไฟล์ที่เปลี่ยนแปลง
git status

# 5. เพิ่มไฟล์ & Commit
git add .
git commit -m "feat: สร้างหน้า Shop page"

# 6. Push ขึ้น GitHub
git push origin feature/frontend
```

---

## ✅ Checklist ของพลับ

- [ ] ติดตั้ง Git, PHP, Composer, Node.js, VS Code
- [ ] Clone โปรเจกต์ & สลับ branch `feature/frontend`
- [ ] ติดตั้ง dependencies & ทดสอบ
- [ ] สร้าง Layout หลัก (`layouts/app.blade.php`)
- [ ] สร้าง CSS (`public/css/style.css`)
- [ ] สร้าง HomeController & หน้า Home
- [ ] สร้าง ShopController & หน้ารายการสินค้า
- [ ] สร้างหน้ารายละเอียดสินค้า
- [ ] เพิ่ม Routes
- [ ] Commit & Push ขึ้น GitHub
- [ ] แจ้งหยางว่าทำเสร็จแล้ว

---

## 🆘 แก้ปัญหาเบื้องต้น

| ปัญหา | วิธีแก้ |
|---|---|
| `composer: command not found` | ติดตั้ง Composer ใหม่ หรือเพิ่ม PATH |
| หน้าเว็บ 500 Error | ตรวจสอบ `.env` ว่าถูกต้อง, รัน `php artisan key:generate` |
| CSS ไม่โหลด | ตรวจสอบ path ใน `<link>`, รัน `npm run dev` |
| `git push` ไม่ได้ | ตรวจสอบว่า checkout ถูก branch, ลอง `git pull` ก่อน |
| ไม่เห็น branch | รัน `git fetch --all` แล้ว `git branch -a` |
