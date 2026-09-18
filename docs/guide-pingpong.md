# 🏓 คู่มือสำหรับ ปิงปอง (User Profile & Admin Dashboard)

## 📋 งานของปิงปอง
- หน้าโปรไฟล์ผู้ใช้ (ดู/แก้ไขข้อมูล, เปลี่ยนรหัสผ่าน)
- Admin Dashboard (สรุปข้อมูลร้านค้า)
- จัดการผู้ใช้ (ดู/แก้ไข/ลบ users)

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
git config --global user.name "ปิงปอง"
git config --global user.email "pingpong-email@example.com"
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

### 2.2 สลับไปยัง Branch ของปิงปอง
```bash
# ดึงข้อมูล branch ทั้งหมด
git fetch --all

# สลับไป branch ของปิงปอง
git checkout feature/admin

# ตรวจสอบ
git branch
# ควรเห็น: * feature/admin
```

### 2.3 ติดตั้ง Dependencies
```bash
composer install
npm install

# คัดลอก .env (แก้ตามที่หยางส่งมา)
cp .env.example .env
# ⚠️ แก้ไข .env ตามที่หยางส่งมาทาง Line/Discord

php artisan key:generate
```

### 2.4 ทดสอบ
```bash
php artisan serve
# เปิด http://localhost:8000
```

---

## 💻 ขั้นตอนที่ 3: เริ่มเขียนโค้ด

### 3.1 สร้าง Controllers

#### ProfileController (จัดการโปรไฟล์ผู้ใช้)

> 💡 **หมายเหตุ:** ไฟล์ `app/Http/Controllers/ProfileController.php` อาจถูกสร้างไว้แล้วตั้งแต่ตอนที่หยางติดตั้ง Laravel Breeze  
> - ถ้ารัน `php artisan make:controller ProfileController` แล้วขึ้น `Controller already exists` ไม่ต้องตกใจ  
> - ให้เปิดไฟล์ `app/Http/Controllers/ProfileController.php` แล้วเขียนทับเนื้อหาด้วยโค้ดด้านล่างได้ทันที

แก้ไข `app/Http/Controllers/ProfileController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // แสดงหน้าโปรไฟล์
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user(),
        ]);
    }

    // แสดงฟอร์มแก้ไขโปรไฟล์
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    // อัพเดทโปรไฟล์
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('profile.show')
            ->with('success', 'อัพเดทโปรไฟล์สำเร็จ!');
    }

    // แสดงฟอร์มเปลี่ยนรหัสผ่าน
    public function editPassword()
    {
        return view('profile.password');
    }

    // อัพเดทรหัสผ่าน
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        // ตรวจสอบรหัสผ่านเก่า
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเก่าไม่ถูกต้อง']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ!');
    }
}
```

#### Admin DashboardController
```bash
php artisan make:controller Admin/DashboardController
```

แก้ไข `app/Http/Controllers/Admin/DashboardController.php`:
```php
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
```

#### Admin UserController
```bash
php artisan make:controller Admin/UserController
```

แก้ไข `app/Http/Controllers/Admin/UserController.php`:
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // แสดงรายการผู้ใช้ทั้งหมด
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // แสดงฟอร์มแก้ไข
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // อัพเดทข้อมูลผู้ใช้
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'phone' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'email', 'role', 'phone']);

        // ถ้าใส่รหัสผ่านใหม่
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'แก้ไขข้อมูลผู้ใช้สำเร็จ!');
    }

    // ลบผู้ใช้
    public function destroy(User $user)
    {
        // ป้องกันลบตัวเอง
        if ($user->id === auth()->id()) {
            return back()->with('error', 'ไม่สามารถลบบัญชีตัวเองได้!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'ลบผู้ใช้สำเร็จ!');
    }
}
```

### 3.2 สร้าง Views

#### หน้าโปรไฟล์
สร้างไฟล์ `resources/views/profile/show.blade.php`:
```html
@extends('layouts.app')

@section('title', 'โปรไฟล์ของฉัน')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="bi bi-person-circle"></i> โปรไฟล์ของฉัน</h3>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> แก้ไข
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">ชื่อ:</div>
                        <div class="col-sm-9">{{ $user->name }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">อีเมล:</div>
                        <div class="col-sm-9">{{ $user->email }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">เบอร์โทร:</div>
                        <div class="col-sm-9">{{ $user->phone ?? 'ยังไม่ได้ระบุ' }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">ที่อยู่:</div>
                        <div class="col-sm-9">{{ $user->address ?? 'ยังไม่ได้ระบุ' }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">บทบาท:</div>
                        <div class="col-sm-9">
                            @if($user->isAdmin())
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">สมัครเมื่อ:</div>
                        <div class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <hr>
                    <a href="{{ route('profile.password') }}" class="btn btn-outline-warning">
                        <i class="bi bi-key"></i> เปลี่ยนรหัสผ่าน
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### ฟอร์มแก้ไขโปรไฟล์
สร้างไฟล์ `resources/views/profile/edit.blade.php`:
```html
@extends('layouts.app')

@section('title', 'แก้ไขโปรไฟล์')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4"><i class="bi bi-pencil"></i> แก้ไขโปรไฟล์</h3>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">อีเมล <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">เบอร์โทรศัพท์</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ที่อยู่</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                      rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> บันทึก
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### ฟอร์มเปลี่ยนรหัสผ่าน
สร้างไฟล์ `resources/views/profile/password.blade.php`:
```html
@extends('layouts.app')

@section('title', 'เปลี่ยนรหัสผ่าน')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4"><i class="bi bi-key"></i> เปลี่ยนรหัสผ่าน</h3>

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">รหัสผ่านเก่า <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">อย่างน้อย 8 ตัวอักษร</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ยืนยันรหัสผ่านใหม่ <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <hr>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-lg"></i> เปลี่ยนรหัสผ่าน
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### Admin Dashboard
สร้างไฟล์ `resources/views/admin/dashboard.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

{{-- สรุปข้อมูล --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">ผู้ใช้ทั้งหมด</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_users']) }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">สินค้าทั้งหมด</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_products']) }}</h2>
                    </div>
                    <i class="bi bi-box fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">คำสั่งซื้อ</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_orders']) }}</h2>
                    </div>
                    <i class="bi bi-receipt fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">รายได้รวม</h6>
                        <h2 class="mb-0">฿{{ number_format($stats['total_revenue'], 0) }}</h2>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- คำสั่งซื้อล่าสุด --}}
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> คำสั่งซื้อล่าสุด</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>เลขที่</th>
                            <th>ลูกค้า</th>
                            <th>ยอด</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_orders'] as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-danger">฿{{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_color }}">{{ $order->status_thai }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">ยังไม่มีคำสั่งซื้อ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- สมาชิกใหม่ --}}
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> สมาชิกใหม่</h5>
            </div>
            <div class="card-body">
                @forelse($stats['recent_users'] as $user)
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 40px; height: 40px; font-size: 14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }} ms-auto">
                        {{ $user->role }}
                    </span>
                </div>
                @empty
                <p class="text-center text-muted">ยังไม่มีสมาชิก</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ข้อมูลเพิ่มเติม --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5>{{ $stats['total_categories'] }}</h5>
                        <p class="text-muted">หมวดหมู่</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['pending_orders'] }}</h5>
                        <p class="text-muted">รอดำเนินการ</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['total_users'] }}</h5>
                        <p class="text-muted">สมาชิกทั้งหมด</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['total_products'] }}</h5>
                        <p class="text-muted">สินค้าทั้งหมด</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### จัดการผู้ใช้ (Admin)
สร้างไฟล์ `resources/views/admin/users/index.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'จัดการผู้ใช้')

@section('content')
<h2 class="mb-4"><i class="bi bi-people"></i> จัดการผู้ใช้</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>เบอร์โทร</th>
                    <th>บทบาท</th>
                    <th>วันที่สมัคร</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-primary">User</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('ยืนยันการลบผู้ใช้ {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
```

#### แก้ไขผู้ใช้ (Admin)
สร้างไฟล์ `resources/views/admin/users/edit.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'แก้ไขผู้ใช้')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> แก้ไขผู้ใช้: {{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อ <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">อีเมล <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">เบอร์โทร</label>
                        <input type="tel" name="phone" class="form-control"
                               value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">บทบาท <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <hr>
                    <h5 class="text-muted">เปลี่ยนรหัสผ่าน (ไม่บังคับ)</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">รหัสผ่านใหม่</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">เว้นว่างถ้าไม่ต้องการเปลี่ยน</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> บันทึก
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

### 3.3 เพิ่ม Routes

เพิ่มใน `routes/web.php`:
```php
// ============================================
// 👤 โปรไฟล์ (ปิงปอง)
// ============================================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ============================================
// ⚙️ Admin Dashboard & Users (ปิงปอง)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
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
git commit -m "feat: ระบบโปรไฟล์ผู้ใช้, Admin Dashboard, จัดการ Users"

# Push ขึ้น GitHub
git push origin feature/admin
```

### วิธี Commit แยกตามงาน (แนะนำ)
```bash
# Commit 1: Profile
git add app/Http/Controllers/ProfileController.php resources/views/profile/
git commit -m "feat: ระบบโปรไฟล์ผู้ใช้ (ดู/แก้ไข/เปลี่ยนรหัสผ่าน)"

# Commit 2: Admin Dashboard
git add app/Http/Controllers/Admin/DashboardController.php resources/views/admin/dashboard.blade.php
git commit -m "feat: Admin Dashboard แสดงสรุปข้อมูลร้านค้า"

# Commit 3: User Management
git add app/Http/Controllers/Admin/UserController.php resources/views/admin/users/
git commit -m "feat: ระบบจัดการผู้ใช้ใน Admin Panel"

# Push ทั้งหมด
git push origin feature/admin
```

---

## ✅ Checklist ของปิงปอง

- [ ] ติดตั้ง Git, PHP, Composer, Node.js, VS Code
- [ ] Clone โปรเจกต์ & สลับ branch `feature/admin`
- [ ] ติดตั้ง dependencies & ตั้งค่า .env
- [ ] สร้าง ProfileController
- [ ] สร้าง Views: profile (show, edit, password)
- [ ] สร้าง Admin DashboardController
- [ ] สร้าง Views: admin dashboard
- [ ] สร้าง Admin UserController (ดู/แก้/ลบ)
- [ ] สร้าง Views: admin users (index, edit)
- [ ] เพิ่ม Routes
- [ ] ทดสอบว่าทำงานได้
- [ ] Commit & Push ขึ้น GitHub
- [ ] แจ้งหยางว่าทำเสร็จแล้ว

---

## 🆘 แก้ปัญหาเบื้องต้น

| ปัญหา | วิธีแก้ |
|---|---|
| `Model Product/Order not found` | Models เหล่านี้จะมีเมื่อ merge กับ branch อื่นแล้ว ตอน dev ให้ใส่ `use App\Models\Product;` ไว้ก่อน |
| Dashboard error count | ตาราง products, orders อาจยังไม่มี ใช้ `try-catch` หรือตรวจสอบก่อน |
| `auth()->user()` return null | ต้อง login ก่อน ตรวจสอบ middleware `auth` |
| `git push` ไม่ได้ | `git pull origin feature/admin` ก่อน แล้ว push ใหม่ |

> 💡 **เทคนิค:** ถ้ายังไม่มี Model ที่คนอื่นสร้าง ให้ทำ Dashboard แบบ static ก่อน (ใส่ตัวเลขจำลอง) แล้วค่อยแก้ตอน merge
