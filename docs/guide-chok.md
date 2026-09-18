# 📦 คู่มือสำหรับ โชค (Product Management)

## 📋 งานของโชค
- สร้าง Migration ตาราง `categories` และ `products`
- สร้าง Model: Category, Product
- CRUD สินค้า (Admin Panel) - เพิ่ม/แก้ไข/ลบสินค้า
- CRUD หมวดหมู่ (Admin Panel) - เพิ่ม/แก้ไข/ลบหมวดหมู่
- อัพโหลดรูปสินค้า

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
git config --global user.name "โชค"
git config --global user.email "chok-email@example.com"
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

### 1.4 ติดตั้ง Node.js & NPM
ไปที่ https://nodejs.org/ ดาวน์โหลด **LTS version**

### 1.5 ติดตั้ง Code Editor
แนะนำ **Visual Studio Code** → https://code.visualstudio.com/

---

## 📥 ขั้นตอนที่ 2: ดึงโค้ดจาก GitHub

### 2.1 Clone โปรเจกต์
```bash
# Clone repo
git clone https://github.com/YangNobody12/e-commerce.git

# เข้าไปในโฟลเดอร์
cd e-commerce
```

### 2.2 เปิดโปรเจกต์ใน VS Code & เปิด Terminal
- **วิธีที่ 1 (ผ่าน Terminal):** พิมพ์คำสั่ง `code .` แล้วกด Enter
- **วิธีที่ 2 (ผ่านโปรแกรม):** เปิดโปรแกรม VS Code ➔ **File** > **Open Folder...** (macOS: **Open...**) ➔ เลือกโฟลเดอร์ `e-commerce`

> 🖥️ **วิธีเปิด Terminal ใน VS Code:**  
> ไปที่เมนู **Terminal** > **New Terminal** (หรือกดคีย์ลัด: ``Ctrl + ` `` สำหรับ Windows หรือ ``Cmd + ` `` สำหรับ macOS)  
> แล้วรันคำสั่งทั้งหมดต่อจากนี้ใน Terminal ของ VS Code ได้เลย!

### 2.3 สลับไปยัง Branch ของโชค
```bash
# รันใน Terminal ของ VS Code:
# ดึงข้อมูล branch ทั้งหมด
git fetch --all

# สลับไป branch ของโชค
git checkout feature/products

# ตรวจสอบ
git branch
# ควรเห็น: * feature/products
```

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

#### Migration สำหรับ Categories
```bash
php artisan make:migration create_categories_table
```

แก้ไขไฟล์ `database/migrations/xxxx_xx_xx_create_categories_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

#### Migration สำหรับ Products
```bash
php artisan make:migration create_products_table
```

แก้ไขไฟล์ `database/migrations/xxxx_xx_xx_create_products_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

#### รัน Migration
```bash
php artisan migrate
```

### 3.2 สร้าง Models

#### สร้าง Model Category
```bash
php artisan make:model Category
```

แก้ไข `app/Models/Category.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    // สร้าง slug อัตโนมัติจากชื่อ
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ความสัมพันธ์: หมวดหมู่มีหลายสินค้า
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

#### สร้าง Model Product
```bash
php artisan make:model Product
```

แก้ไข `app/Models/Product.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ความสัมพันธ์: สินค้าอยู่ในหมวดหมู่
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

### 3.3 สร้าง Controllers

#### Controller จัดการหมวดหมู่ (Admin)
```bash
php artisan make:controller Admin/CategoryController --resource
```

แก้ไข `app/Http/Controllers/Admin/CategoryController.php`:
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // แสดงรายการหมวดหมู่ทั้งหมด
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // แสดงฟอร์มสร้างหมวดหมู่
    public function create()
    {
        return view('admin.categories.create');
    }

    // บันทึกหมวดหมู่ใหม่
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        // อัพโหลดรูป
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $data['image'] = 'images/categories/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'เพิ่มหมวดหมู่สำเร็จ!');
    }

    // แสดงฟอร์มแก้ไขหมวดหมู่
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // อัพเดทหมวดหมู่
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $data['image'] = 'images/categories/' . $imageName;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'แก้ไขหมวดหมู่สำเร็จ!');
    }

    // ลบหมวดหมู่
    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'ลบหมวดหมู่สำเร็จ!');
    }
}
```

#### Controller จัดการสินค้า (Admin)
```bash
php artisan make:controller Admin/ProductController --resource
```

แก้ไข `app/Http/Controllers/Admin/ProductController.php`:
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'เพิ่มสินค้าสำเร็จ!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'แก้ไขสินค้าสำเร็จ!');
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'ลบสินค้าสำเร็จ!');
    }
}
```

### 3.4 สร้าง Views (Admin)

#### สร้าง Admin Layout

> 💡 **หมายเหตุ:** ไฟล์ `resources/views/admin/layouts/app.blade.php` หยางได้สร้างไว้เป็น Layout ส่วนกลางตั้งแต่ตอนเริ่มโปรเจกต์แล้ว หากมีไฟล์นี้อยู่แล้วสามารถข้ามขั้นตอนนี้ หรือตรวจสอบว่ามีโครงสร้างเหมือนด้านล่างได้เลย

สร้างไฟล์ `resources/views/admin/layouts/app.blade.php` (ถ้ายังไม่มี):
```html
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="admin-sidebar d-flex flex-column p-3" style="width: 250px;">
            <a href="{{ url('/admin') }}" class="text-white text-decoration-none mb-4">
                <h4><i class="bi bi-gear"></i> Admin Panel</h4>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/products') }}">
                        <i class="bi bi-box"></i> สินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/categories') }}">
                        <i class="bi bi-tags"></i> หมวดหมู่
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/orders') }}">
                        <i class="bi bi-receipt"></i> คำสั่งซื้อ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/users') }}">
                        <i class="bi bi-people"></i> ผู้ใช้
                    </a>
                </li>
                <hr class="text-white">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="bi bi-arrow-left"></i> กลับหน้าเว็บ
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-text">สวัสดี, {{ Auth::user()->name }}</span>
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

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

#### หน้ารายการสินค้า (Admin)
สร้างไฟล์ `resources/views/admin/products/index.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'จัดการสินค้า')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box"></i> จัดการสินค้า</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> เพิ่มสินค้า
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>รูป</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคา</th>
                    <th>สต็อก</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                        @else
                            <span class="text-muted">ไม่มีรูป</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td class="text-danger fw-bold">฿{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success">เปิดขาย</span>
                        @else
                            <span class="badge bg-secondary">ปิดขาย</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">ยังไม่มีสินค้า</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</div>
@endsection
```

#### ฟอร์มเพิ่มสินค้า
สร้างไฟล์ `resources/views/admin/products/create.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'เพิ่มสินค้า')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-lg"></i> เพิ่มสินค้าใหม่</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อสินค้า <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">หมวดหมู่ <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- เลือกหมวดหมู่ --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">รายละเอียด <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ราคา (บาท) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">จำนวนสต็อก <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', 0) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">รูปสินค้า</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">เปิดขาย</label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> บันทึกสินค้า
            </button>
        </form>
    </div>
</div>
@endsection
```

#### ฟอร์มแก้ไขสินค้า
สร้างไฟล์ `resources/views/admin/products/edit.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'แก้ไขสินค้า')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> แก้ไขสินค้า: {{ $product->name }}</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อสินค้า <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">หมวดหมู่ <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- เลือกหมวดหมู่ --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">รายละเอียด <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ราคา (บาท) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">จำนวนสต็อก <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', $product->stock) }}" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">รูปสินค้า</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset($product->image) }}" class="img-thumbnail" width="150">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">ถ้าไม่เลือกรูปใหม่ จะใช้รูปเดิม</small>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">เปิดขาย</label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> บันทึกการแก้ไข
            </button>
        </form>
    </div>
</div>
@endsection
```

#### หน้ารายการหมวดหมู่ (Admin)
สร้างไฟล์ `resources/views/admin/categories/index.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'จัดการหมวดหมู่')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-tags"></i> จัดการหมวดหมู่</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> เพิ่มหมวดหมู่
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>รูป</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th>จำนวนสินค้า</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" width="50" height="50" class="rounded">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }} รายการ</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('ยืนยันการลบหมวดหมู่นี้? สินค้าในหมวดหมู่จะถูกลบด้วย')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">ยังไม่มีหมวดหมู่</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
</div>
@endsection
```

#### ฟอร์มเพิ่มหมวดหมู่
สร้างไฟล์ `resources/views/admin/categories/create.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'เพิ่มหมวดหมู่')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-lg"></i> เพิ่มหมวดหมู่ใหม่</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">คำอธิบาย</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">รูปหมวดหมู่</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> บันทึก
            </button>
        </form>
    </div>
</div>
@endsection
```

#### ฟอร์มแก้ไขหมวดหมู่
สร้างไฟล์ `resources/views/admin/categories/edit.blade.php`:
```html
@extends('admin.layouts.app')

@section('title', 'แก้ไขหมวดหมู่')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> แก้ไขหมวดหมู่: {{ $category->name }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">คำอธิบาย</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">รูปหมวดหมู่</label>
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ asset($category->image) }}" class="img-thumbnail" width="150">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">ถ้าไม่เลือกรูปใหม่ จะใช้รูปเดิม</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> บันทึกการแก้ไข
            </button>
        </form>
    </div>
</div>
@endsection
```

### 3.5 เพิ่ม Routes

เพิ่มใน `routes/web.php` ในส่วน Admin:
```php
// ============================================
// 📦 จัดการสินค้า & หมวดหมู่ (โชค)
// ============================================
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// ใส่ใน middleware group admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});
```

### 3.6 สร้าง Seeder สำหรับข้อมูลทดสอบ
```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder ProductSeeder
```

แก้ไข `database/seeders/CategorySeeder.php`:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'เสื้อผ้า', 'slug' => 'clothes', 'description' => 'เสื้อผ้าแฟชั่น'],
            ['name' => 'รองเท้า', 'slug' => 'shoes', 'description' => 'รองเท้าแบรนด์'],
            ['name' => 'กระเป๋า', 'slug' => 'bags', 'description' => 'กระเป๋าแฟชั่น'],
            ['name' => 'เครื่องประดับ', 'slug' => 'accessories', 'description' => 'เครื่องประดับต่างๆ'],
            ['name' => 'อิเล็กทรอนิกส์', 'slug' => 'electronics', 'description' => 'อุปกรณ์อิเล็กทรอนิกส์'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
```

---

## 📤 ขั้นตอนที่ 4: Commit & Push โค้ด

### 4.1 ตรวจสอบไฟล์ที่เปลี่ยนแปลง
```bash
git status
```

### 4.2 Commit & Push
```bash
# เพิ่มไฟล์ทั้งหมด
git add .

# Commit
git commit -m "feat: สร้าง CRUD สินค้าและหมวดหมู่ (Admin)"

# Push ขึ้น GitHub
git push origin feature/products
```

### 4.3 Commit แยกตามงาน (แนะนำ)
```bash
# Commit 1: Migration & Models
git add database/migrations/ app/Models/
git commit -m "feat: สร้าง migration และ model สำหรับ products, categories"

# Commit 2: Controllers
git add app/Http/Controllers/Admin/
git commit -m "feat: สร้าง CRUD controllers สำหรับ products, categories"

# Commit 3: Views
git add resources/views/admin/
git commit -m "feat: สร้าง admin views สำหรับจัดการสินค้าและหมวดหมู่"

# Push ทั้งหมด
git push origin feature/products
```

---

## ✅ Checklist ของโชค

- [ ] ติดตั้ง Git, PHP, Composer, Node.js, VS Code
- [ ] Clone โปรเจกต์ & สลับ branch `feature/products`
- [ ] ติดตั้ง dependencies & ตั้งค่า .env
- [ ] สร้าง Migration: categories, products
- [ ] สร้าง Model: Category, Product
- [ ] สร้าง Admin CategoryController (CRUD)
- [ ] สร้าง Admin ProductController (CRUD)
- [ ] สร้าง Admin Layout
- [ ] สร้าง Views: products (index, create, edit)
- [ ] สร้าง Views: categories (index, create, edit)
- [ ] เพิ่ม Routes
- [ ] สร้าง Seeder ข้อมูลทดสอบ
- [ ] ทดสอบว่าทำงานได้
- [ ] Commit & Push ขึ้น GitHub
- [ ] แจ้งหยางว่าทำเสร็จแล้ว

---

## 🆘 แก้ปัญหาเบื้องต้น

| ปัญหา | วิธีแก้ |
|---|---|
| Migration error | ตรวจสอบ `.env` ว่า database credentials ถูกต้อง |
| `Table not found` | รัน `php artisan migrate` |
| `Class not found` | รัน `composer dump-autoload` |
| รูปไม่แสดง | ตรวจสอบว่าสร้างโฟลเดอร์ `public/images/products` และ `public/images/categories` |
| `git push` ไม่ได้ | ตรวจสอบ branch: `git branch`, ลอง `git pull` ก่อน |
