# 👑 คู่มือสำหรับ หยาง (Team Lead / DevOps & Auth)

## 📋 งานของหยาง
- ตั้งค่าโปรเจกต์ Laravel ทั้งหมด
- เชื่อมต่อ Supabase Database
- ระบบ Login / Register (Laravel Breeze)
- สร้าง AdminMiddleware
- **Merge branch ของทุกคนเข้า develop → main**

---

## 🔧 ขั้นตอนที่ 1: ติดตั้งเครื่องมือที่จำเป็น

### 1.1 ติดตั้ง Git
```bash
# macOS (ใช้ Homebrew)
brew install git

# Windows (ดาวน์โหลดจาก)
# https://git-scm.com/download/win
# ติดตั้งแบบ Next > Next > Finish

# ตรวจสอบว่าติดตั้งสำเร็จ
git --version
```

### 1.2 ตั้งค่า Git (ทำครั้งเดียว)
```bash
git config --global user.name "หยาง"
git config --global user.email "your-email@example.com"
```

### 1.3 ติดตั้ง PHP 8.2+ & Composer

**สำหรับ Windows (ติดตั้งผ่าน PowerShell คำสั่งเดียวจบ):**
1. เปิด **PowerShell แบบ Run as Administrator** (คลิกขวาที่ปุ่ม Start ➔ เลือก Terminal (Admin) หรือ PowerShell (Admin))
2. รันคำสั่งนี้แล้วกด Enter:
```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows'))
```
*(คำสั่งนี้จะดาวน์โหลดและติดตั้งทั้ง PHP + Composer พร้อมตั้งค่า PATH และ Extensions ให้อัตโนมัติในคำสั่งเดียว)*

**สำหรับ macOS:**
```bash
brew install php
brew install composer
```

**ตรวจสอบว่าติดตั้งสำเร็จ (เปิดหน้าต่าง PowerShell หรือ CMD ใหม่):**
```bash
php --version
composer --version
```

### 1.4 ติดตั้ง Node.js & NPM

**สำหรับ Windows (ติดตั้งผ่าน PowerShell):**
รันคำสั่งนี้ใน **PowerShell**:
```powershell
winget install OpenJS.NodeJS.LTS
```

**สำหรับ macOS:**
```bash
brew install node
```

**ตรวจสอบว่าติดตั้งสำเร็จ:**
```bash
node --version
npm --version
```

### 1.5 ติดตั้ง Visual Studio Code (VS Code)
- ดาวน์โหลดตัวติดตั้งจาก https://code.visualstudio.com/
- ติดตั้งตามขั้นตอนปกติ (Next > Finish)
- **Extensions แนะนำใน VS Code:** (กดไอคอน Extensions ทางซ้าย หรือกด `Ctrl+Shift+X` / `Cmd+Shift+X` แล้วค้นหา):
  - **PHP Intelephense** (ช่วย autocomplete คำสั่งและฟังก์ชัน PHP)
  - **Laravel Blade Snippets** (ช่วยไฮไลต์สีและ snippet ให้ไฟล์ `.blade.php`)
  - **Bootstrap 5 & FontAwesome Snippets**

---

## 🚀 ขั้นตอนที่ 2: ตั้งค่าโปรเจกต์ Laravel

### 2.1 Clone Repo จาก GitHub
```bash
# Clone repo ที่สร้างไว้แล้ว
git clone https://github.com/YangNobody12/e-commerce.git

# เข้าไปยังโฟลเดอร์โปรเจกต์
cd e-commerce
```

### 2.2 เปิดโปรเจกต์ใน VS Code & เปิด Terminal

สามารถเปิดโปรเจกต์ใน VS Code ได้ 2 วิธี:

- **วิธีที่ 1 (ผ่าน Terminal - เร็วและสะดวกที่สุด):**  
  พิมพ์คำสั่งนี้ในหน้าต่าง terminal ขณะอยู่ที่โฟลเดอร์ `e-commerce`:
  ```bash
  code .
  ```
  *(โปรแกรม VS Code จะเปิดโฟลเดอร์ e-commerce ขึ้นมาทันที)*

- **วิธีที่ 2 (เปิดจากโปรแกรม VS Code โดยตรง):**
  1. เปิดโปรแกรม **Visual Studio Code**
  2. ไปที่เมนูด้านบนเลือก **File** > **Open Folder...** (macOS: **File** > **Open...**)
  3. ค้นหาและเลือกโฟลเดอร์ `e-commerce` ที่เพิ่ง clone มา แล้วกด **Select Folder** (หรือ **Open**)

#### 🖥️ วิธีเปิด Terminal ภายใน VS Code:
หลังจากเปิดโฟลเดอร์ใน VS Code แล้ว แนะนำให้ใช้ Terminal ข้างในโปรแกรม จะได้พิมพ์คำสั่งได้สะดวกโดยไม่ต้องสลับหน้าต่าง:
1. ไปที่เมนูด้านบนเลือก **Terminal** > **New Terminal**
   - หรือกดคีย์ลัด: ``Ctrl + ` `` (Windows) หรือ ``Cmd + ` `` (macOS) (ปุ่มตัวหนอน `~` ใต้ปุ่ม Esc)
2. แถบ Terminal จะเปิดขึ้นมาที่ด้านล่างของหน้าจอ และจะอยู่ที่โฟลเดอร์ `e-commerce` โดยตรง
3. **หลังจากนี้สามารถรันคำสั่งทั้งหมดใน Terminal ของ VS Code นี้ได้เลย!**

### 2.3 สร้าง Laravel Project
```bash
# รันคำสั่งนี้ใน Terminal ของ VS Code:
# สร้าง Laravel project ไว้ในโฟลเดอร์ชั่วคราว
composer create-project laravel/laravel temp-laravel

# ย้ายไฟล์ทั้งหมดรวมถึงไฟล์ซ่อน (.env, .gitignore) มาไว้ที่ root
cp -R temp-laravel/. .
rm -rf temp-laravel

# ติดตั้ง dependencies
composer install
npm install
```

### 2.4 ตั้งค่า Environment (.env)
```bash
# copy .env.example มาเป็น .env
cp .env.example .env

# สร้าง app key
php artisan key:generate
```

### 2.5 แก้ไขไฟล์ `.env` เชื่อมต่อ Supabase
```env
APP_NAME="E-Commerce"
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=db.xxxxxxxxxxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-supabase-password
```

> 💡 **วิธีหา Supabase credentials:**
> 1. ไปที่ https://supabase.com → เข้า Project ของเรา
> 2. ไปที่ **Settings** → **Database**
> 3. ดูที่ **Connection string** → เลือก **URI**
> 4. จะเห็น Host, Password ที่ต้องใช้

### 2.6 ติดตั้ง Laravel Breeze (ระบบ Auth)
```bash
# ติดตั้ง Breeze package
composer require laravel/breeze --dev

# ติดตั้ง Breeze scaffolding แบบ Blade
php artisan breeze:install blade
```

> 💡 **คำแนะนำเมื่อหน้าต่างถามคำถาม:**
> - `Would you like dark mode support?` ➔ เลือก **no**
> - `Which testing framework do you prefer?` ➔ กด **Enter** (เลือกค่าเริ่มต้น Pest หรือ PHPUnit)

```bash
# ติดตั้ง frontend packages และ build
npm install
npm run build
```

### 2.7 ตั้งค่า Pagination ให้เป็น Bootstrap 5
เนื่องจากทีมใช้ Bootstrap 5 ในหน้าแสดงผล ต้องตั้งค่าให้ Laravel pagination render สไตล์ Bootstrap (ไม่งั้นปุ่มเปลี่ยนหน้าจะกลายเป็นปุ่มลูกศรยักษ์ของ Tailwind)

แก้ไข `app/Providers/AppServiceProvider.php`:
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
```

### 2.8 สร้าง Layout กลางสำหรับ Admin (แชร์ให้ทั้งทีม)
เพื่อให้ โชค, ปิงปอง, และ กวาง เรียกใช้ `@extends('admin.layouts.app')` ได้ทันทีโดยไม่ติด error `View [admin.layouts.app] not found`

สร้างไฟล์ `resources/views/admin/layouts/app.blade.php`:
```html
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">
        {{-- Sidebar --}}
        <div class="admin-sidebar d-flex flex-column p-3 bg-dark text-white" style="width: 250px;">
            <a href="{{ url('/admin') }}" class="text-white text-decoration-none mb-4">
                <h4><i class="bi bi-gear"></i> Admin Panel</h4>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/products') }}">
                        <i class="bi bi-box"></i> สินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/categories') }}">
                        <i class="bi bi-tags"></i> หมวดหมู่
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/orders') }}">
                        <i class="bi bi-receipt"></i> คำสั่งซื้อ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/users') }}">
                        <i class="bi bi-people"></i> ผู้ใช้
                    </a>
                </li>
                <hr class="text-white">
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="{{ url('/') }}">
                        <i class="bi bi-arrow-left"></i> กลับหน้าเว็บ
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-text">สวัสดี, {{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">ออกจากระบบ</button>
                </form>
            </nav>

            <div class="p-4">
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

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

สร้างไฟล์ `public/css/admin.css`:
```css
.admin-sidebar {
    min-height: 100vh;
    background-color: #212529;
}
.admin-sidebar .nav-link {
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 4px;
    transition: all 0.2s;
}
.admin-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
}
```

---

## 🔐 ขั้นตอนที่ 3: สร้างระบบ Authentication

### 3.1 แก้ไข Migration ตาราง Users
สร้างไฟล์ `database/migrations/xxxx_xx_xx_create_users_table.php` (มีอยู่แล้วจาก Laravel)

แก้ไขให้เป็น:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
```

### 3.2 แก้ไข Model User
แก้ไขไฟล์ `app/Models/User.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ตรวจสอบว่าเป็น Admin หรือไม่
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
```

### 3.3 สร้าง Admin Middleware
```bash
php artisan make:middleware AdminMiddleware
```

แก้ไข `app/Http/Middleware/AdminMiddleware.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return $next($request);
    }
}
```

### 3.4 ลงทะเบียน Middleware
แก้ไข `bootstrap/app.php`:
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### 3.5 ตั้งค่า Routes เริ่มต้น
แก้ไข `routes/web.php`:
```php
<?php

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

// ============================================
// Routes ที่ต้อง Login ก่อน
// ============================================
Route::middleware(['auth'])->group(function () {

    // 🛒 ตะกร้า & คำสั่งซื้อ (กวาง)
    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // ... กวางเพิ่มเอง

    // 👤 โปรไฟล์ (ปิงปอง)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // ... ปิงปองเพิ่มเอง

    // 📦 คำสั่งซื้อ (กวาง)
    // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    // ... กวางเพิ่มเอง
});

// ============================================
// ⚙️ Admin Routes (ต้อง Login + เป็น Admin)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // 📊 Dashboard (ปิงปอง)
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 📦 จัดการสินค้า (โชค)
    // Route::resource('products', ProductController::class);
    // Route::resource('categories', CategoryController::class);

    // 👥 จัดการผู้ใช้ (ปิงปอง)
    // Route::resource('users', UserController::class);

    // 📋 จัดการคำสั่งซื้อ (กวาง)
    // Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
});

// ============================================
// 🏪 หน้าร้าน (พลับ)
// ============================================
// Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
// Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
```

### 3.6 สร้าง Seeder สำหรับ Admin User
```bash
php artisan make:seeder AdminUserSeeder
```

แก้ไข `database/seeders/AdminUserSeeder.php`:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User ทดสอบ',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}
```

แก้ไข `database/seeders/DatabaseSeeder.php`:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
```

### 3.7 รัน Migration & Seed
```bash
# รัน migration สร้างตาราง
php artisan migrate

# รัน seeder สร้าง admin user
php artisan db:seed
```

---

## 📤 ขั้นตอนที่ 4: Push โค้ดขึ้น GitHub

### 4.1 สร้าง Branch Structure
```bash
# ตรวจสอบว่าอยู่ที่ main branch
git branch

# สร้าง develop branch
git checkout -b develop

# Add ไฟล์ทั้งหมด
git add .

# Commit
git commit -m "Initial Laravel setup with Breeze auth and Supabase config"

# Push develop ขึ้น GitHub
git push -u origin develop

# สร้าง feature branch ของหยาง
git checkout -b feature/auth

# Push feature branch
git push -u origin feature/auth
```

### 4.2 สร้าง Branch ให้ทีม
```bash
# กลับไป develop
git checkout develop

# สร้าง branch ให้แต่ละคน
git checkout -b feature/frontend
git push -u origin feature/frontend

git checkout develop
git checkout -b feature/products
git push -u origin feature/products

git checkout develop
git checkout -b feature/cart-orders
git push -u origin feature/cart-orders

git checkout develop
git checkout -b feature/admin
git push -u origin feature/admin

# กลับไป branch ของตัวเอง
git checkout feature/auth
```

---

## 🔀 ขั้นตอนที่ 5: การ Merge Branch (เมื่อทีมทำเสร็จ)

### 5.1 Merge Branch ของแต่ละคนเข้า develop
```bash
# อัพเดท develop ก่อน
git checkout develop
git pull origin develop

# Merge branch ของพลับ
git merge origin/feature/frontend
# ถ้ามี conflict → แก้ conflict → git add . → git commit

# Merge branch ของโชค
git merge origin/feature/products

# Merge branch ของกวาง
git merge origin/feature/cart-orders

# Merge branch ของปิงปอง
git merge origin/feature/admin

# Push develop ที่ merge แล้ว
git push origin develop
```

### 5.2 แก้ Conflict (ถ้ามี)
```bash
# เมื่อ merge แล้วเกิด conflict จะเห็นข้อความ CONFLICT
# เปิดไฟล์ที่ conflict แล้วแก้ไข

# ในไฟล์จะเห็น:
# <<<<<<< HEAD
# โค้ดของ develop
# =======
# โค้ดของ feature branch
# >>>>>>> feature/xxx

# แก้ไขให้เหลือโค้ดที่ถูกต้อง แล้ว:
git add .
git commit -m "Resolve merge conflict from feature/xxx"
```

### 5.3 Merge develop เข้า main (Production)
```bash
git checkout main
git merge develop
git push origin main
```

---

## ✅ Checklist ของหยาง

- [ ] ติดตั้ง Git, PHP, Composer, Node.js
- [ ] สร้าง Laravel Project
- [ ] เชื่อมต่อ Supabase
- [ ] ติดตั้ง Laravel Breeze
- [ ] ตั้งค่า `AppServiceProvider` (`Paginator::useBootstrapFive()`)
- [ ] สร้าง Layout Admin กลาง (`resources/views/admin/layouts/app.blade.php`)
- [ ] แก้ไข User Model (เพิ่ม role, phone, address)
- [ ] สร้าง AdminMiddleware & ลงทะเบียนใน `bootstrap/app.php`
- [ ] ตั้งค่า Routes เริ่มต้นใน `routes/web.php`
- [ ] สร้าง AdminUserSeeder
- [ ] รัน Migration & Seed
- [ ] Push ขึ้น develop
- [ ] สร้าง branch ให้ทุกคน
- [ ] ส่งไฟล์ .env ให้ทุกคน
- [ ] รอทุกคน push เสร็จ → Merge เข้า develop
- [ ] ทดสอบทั้งระบบ
- [ ] Merge develop → main

---

## 🆘 คำสั่ง Git ที่ใช้บ่อย

| คำสั่ง | ความหมาย |
|---|---|
| `git status` | ดูสถานะไฟล์ที่เปลี่ยนแปลง |
| `git add .` | เพิ่มไฟล์ทั้งหมดเข้า staging |
| `git commit -m "ข้อความ"` | บันทึกการเปลี่ยนแปลง |
| `git push` | อัพโค้ดขึ้น GitHub |
| `git pull` | ดึงโค้ดล่าสุดจาก GitHub |
| `git checkout branch-name` | สลับ branch |
| `git merge branch-name` | รวม branch เข้ากับ branch ปัจจุบัน |
| `git log --oneline -10` | ดู commit ล่าสุด 10 อัน |
| `git branch` | ดู branch ทั้งหมด |
| `git stash` | เก็บโค้ดที่ยังไม่ commit ไว้ชั่วคราว |
| `git stash pop` | เอาโค้ดที่ stash ไว้กลับมา |
