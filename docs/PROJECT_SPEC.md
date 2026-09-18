# 📦 E-Commerce Project Specification

## 🎯 ภาพรวมโปรเจกต์

ระบบ E-Commerce สำหรับขายสินค้าออนไลน์ พัฒนาด้วย **Laravel** ใช้ **Supabase** เป็นฐานข้อมูล  
รองรับระบบสมาชิก ตะกร้าสินค้า การสั่งซื้อ และจัดการสินค้าฝั่ง Admin

---

## 🛠 Tech Stack

| เทคโนโลยี | รายละเอียด |
|---|---|
| **Backend Framework** | Laravel 11 |
| **Database** | Supabase (PostgreSQL) |
| **Frontend** | Blade Templates + Vanilla CSS / Bootstrap 5 |
| **Authentication** | Laravel Breeze (Email & Password เท่านั้น) |
| **Version Control** | Git + GitHub |
| **PHP Version** | PHP 8.2+ |
| **Package Manager** | Composer (PHP) + NPM (JS/CSS) |

---

## 👥 สมาชิกในทีม & การแบ่งงาน

| คน | บทบาท | Branch | งานหลัก |
|---|---|---|---|
| **หยาง** 👑 | Team Lead / DevOps & Auth | `feature/auth` | ระบบ Login/Register, ตั้งค่าโปรเจกต์, Merge branch ทั้งหมด |
| **พลับ** | Frontend Developer | `feature/frontend` | หน้าเว็บหลัก (Home, Product Listing, Product Detail, Layout) |
| **โชค** | Product Management | `feature/products` | CRUD สินค้า, หมวดหมู่สินค้า (Admin Panel) |
| **กวาง** | Cart & Order System | `feature/cart-orders` | ระบบตะกร้าสินค้า, ระบบสั่งซื้อ |
| **ปิงปอง** | User Profile & Admin | `feature/admin` | จัดการโปรไฟล์ผู้ใช้, Dashboard Admin, จัดการ Users |

---

## 📐 Database Schema (Supabase / PostgreSQL)

### ตาราง `users`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัสผู้ใช้ |
| name | VARCHAR(255) | ชื่อ |
| email | VARCHAR(255) UNIQUE | อีเมล |
| password | VARCHAR(255) | รหัสผ่าน (hashed) |
| role | ENUM('user', 'admin') | บทบาท (default: 'user') |
| phone | VARCHAR(20) NULL | เบอร์โทร |
| address | TEXT NULL | ที่อยู่ |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

### ตาราง `categories`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัสหมวดหมู่ |
| name | VARCHAR(255) | ชื่อหมวดหมู่ |
| slug | VARCHAR(255) UNIQUE | URL slug |
| description | TEXT NULL | คำอธิบาย |
| image | VARCHAR(255) NULL | รูปหมวดหมู่ |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

### ตาราง `products`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัสสินค้า |
| category_id | BIGINT (FK) | หมวดหมู่ |
| name | VARCHAR(255) | ชื่อสินค้า |
| slug | VARCHAR(255) UNIQUE | URL slug |
| description | TEXT | รายละเอียด |
| price | DECIMAL(10,2) | ราคา |
| stock | INTEGER DEFAULT 0 | จำนวนในสต็อก |
| image | VARCHAR(255) NULL | รูปสินค้า |
| is_active | BOOLEAN DEFAULT TRUE | สถานะเปิด/ปิดขาย |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

### ตาราง `carts`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัสตะกร้า |
| user_id | BIGINT (FK) | เจ้าของตะกร้า |
| product_id | BIGINT (FK) | สินค้า |
| quantity | INTEGER DEFAULT 1 | จำนวน |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

### ตาราง `orders`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัสคำสั่งซื้อ |
| user_id | BIGINT (FK) | ผู้สั่งซื้อ |
| order_number | VARCHAR(50) UNIQUE | เลขที่คำสั่งซื้อ |
| total_amount | DECIMAL(10,2) | ยอดรวม |
| status | ENUM('pending','processing','shipped','delivered','cancelled') | สถานะ |
| shipping_name | VARCHAR(255) | ชื่อผู้รับ |
| shipping_address | TEXT | ที่อยู่จัดส่ง |
| shipping_phone | VARCHAR(20) | เบอร์ติดต่อ |
| note | TEXT NULL | หมายเหตุ |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

### ตาราง `order_items`
| Column | Type | Description |
|---|---|---|
| id | BIGINT (PK, AI) | รหัส |
| order_id | BIGINT (FK) | คำสั่งซื้อ |
| product_id | BIGINT (FK) | สินค้า |
| product_name | VARCHAR(255) | ชื่อสินค้า (snapshot) |
| price | DECIMAL(10,2) | ราคาต่อชิ้น (snapshot) |
| quantity | INTEGER | จำนวน |
| subtotal | DECIMAL(10,2) | ยอดรวมย่อย |
| created_at | TIMESTAMP | วันที่สร้าง |
| updated_at | TIMESTAMP | วันที่แก้ไข |

---

## 🗂 โครงสร้างโฟลเดอร์หลัก (Laravel)

```
e-commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           ← หยาง (Login/Register)
│   │   │   ├── HomeController.php        ← พลับ
│   │   │   ├── CartController.php        ← กวาง
│   │   │   ├── OrderController.php       ← กวาง
│   │   │   ├── ProfileController.php     ← ปิงปอง
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php  ← ปิงปอง
│   │   │   │   ├── ProductController.php    ← โชค (Admin CRUD)
│   │   │   │   ├── CategoryController.php   ← โชค (Admin CRUD)
│   │   │   │   ├── OrderController.php      ← กวาง (Admin)
│   │   │   │   └── UserController.php       ← ปิงปอง
│   │   │   └── ShopController.php        ← พลับ (หน้าร้าน)
│   │   └── Middleware/
│   │       └── AdminMiddleware.php       ← หยาง
│   ├── Models/
│   │   ├── User.php            ← หยาง
│   │   ├── Product.php         ← โชค
│   │   ├── Category.php        ← โชค
│   │   ├── Cart.php            ← กวาง
│   │   ├── Order.php           ← กวาง
│   │   └── OrderItem.php       ← กวาง
│   └── ...
├── database/
│   └── migrations/             ← หยาง ตั้งค่าเริ่มต้น, แต่ละคนสร้าง migration ของตัวเอง
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php   ← พลับ (Layout หลัก)
│       ├── auth/               ← หยาง (Login/Register views)
│       ├── home.blade.php      ← พลับ
│       ├── shop/               ← พลับ (หน้าร้านค้า)
│       ├── admin/
│       │   ├── dashboard.blade.php  ← ปิงปอง
│       │   ├── products/       ← โชค
│       │   ├── categories/     ← โชค
│       │   └── users/          ← ปิงปอง
│       ├── cart/               ← กวาง
│       ├── orders/             ← กวาง
│       └── profile/            ← ปิงปอง
├── routes/
│   └── web.php                 ← ทุกคนเพิ่ม route ในนี้ (ระวัง conflict!)
├── public/
│   ├── css/                    ← พลับ
│   ├── js/                     ← พลับ
│   └── images/
├── .env                        ← หยาง ตั้งค่า (ไม่ push ขึ้น git)
└── ...
```

---

## 📄 หน้าเว็บที่ต้องทำ

### 🏪 หน้าร้าน (Frontend - พลับ)
1. **หน้าแรก** (`/`) - แสดงสินค้าแนะนำ, หมวดหมู่
2. **หน้ารายการสินค้า** (`/shop`) - แสดงสินค้าทั้งหมด, กรองตามหมวดหมู่
3. **หน้ารายละเอียดสินค้า** (`/shop/{slug}`) - ข้อมูลสินค้า, ปุ่มเพิ่มตะกร้า
4. **Layout หลัก** - Navbar, Footer, Sidebar

### 🔐 ระบบ Auth (หยาง)
5. **หน้า Login** (`/login`)
6. **หน้า Register** (`/register`)
7. **Logout** (`POST /logout`)

### 🛒 ตะกร้า & คำสั่งซื้อ (กวาง)
8. **หน้าตะกร้า** (`/cart`) - แสดงรายการ, แก้จำนวน, ลบ
9. **หน้า Checkout** (`/checkout`) - กรอกที่อยู่จัดส่ง, ยืนยันสั่งซื้อ
10. **หน้าประวัติคำสั่งซื้อ** (`/orders`) - รายการคำสั่งซื้อของผู้ใช้
11. **หน้ารายละเอียดคำสั่งซื้อ** (`/orders/{id}`) - รายละเอียดคำสั่งซื้อ

### 👤 โปรไฟล์ (ปิงปอง)
12. **หน้าโปรไฟล์** (`/profile`) - ดู/แก้ไขข้อมูลส่วนตัว
13. **แก้ไขรหัสผ่าน** (`/profile/password`)

### ⚙️ Admin Panel
14. **Dashboard** (`/admin`) - สรุปยอดขาย, จำนวนสินค้า, จำนวนคำสั่งซื้อ (ปิงปอง)
15. **จัดการสินค้า** (`/admin/products`) - CRUD สินค้า (โชค)
16. **จัดการหมวดหมู่** (`/admin/categories`) - CRUD หมวดหมู่ (โชค)
17. **จัดการผู้ใช้** (`/admin/users`) - ดู/แก้ไข/ลบ users (ปิงปอง)
18. **จัดการคำสั่งซื้อ** (`/admin/orders`) - อัพเดทสถานะ (กวาง)

---

## 🔄 Git Workflow

```
main (production)
  └── develop (หยาง merge ที่นี่)
        ├── feature/auth         ← หยาง
        ├── feature/frontend     ← พลับ
        ├── feature/products     ← โชค
        ├── feature/cart-orders  ← กวาง
        └── feature/admin        ← ปิงปอง
```

### กฎการทำงานกับ Git
1. **ห้าม push ตรงไป `main` หรือ `develop`** 
2. แต่ละคนทำงานใน branch ของตัวเอง
3. เสร็จแล้ว push ขึ้น GitHub
4. **หยาง** จะเป็นคน merge เข้า `develop` → `main`
5. ก่อนเริ่มทำงานทุกวัน ให้ `git pull` เพื่ออัพเดทโค้ดล่าสุด

---

## ⏱ ลำดับการทำงาน (Timeline)

### Phase 1: Setup (หยาง ทำก่อน)
- [x] สร้าง GitHub Repo
- [ ] ตั้งค่า Laravel Project
- [ ] เชื่อมต่อ Supabase
- [ ] ติดตั้ง Laravel Breeze (Auth)
- [ ] สร้าง Migration ตาราง users
- [ ] สร้าง AdminMiddleware
- [ ] Push ขึ้น `develop` branch
- [ ] แจ้งทีมให้ pull โค้ด

### Phase 2: พัฒนาพร้อมกัน (ทุกคน)
- พลับ: ทำ Layout + หน้าร้าน
- โชค: ทำ CRUD สินค้า/หมวดหมู่
- กวาง: ทำระบบตะกร้า/สั่งซื้อ
- ปิงปอง: ทำ Admin Dashboard + จัดการ Users + Profile

### Phase 3: รวมโค้ด & ทดสอบ (หยาง)
- Merge ทุก branch เข้า `develop`
- แก้ Conflict
- ทดสอบทั้งระบบ
- Merge เข้า `main`

---

## 📝 หมายเหตุสำคัญ

> ⚠️ **ไฟล์ `.env` ห้าม push ขึ้น Git!** ข้อมูล database credentials อยู่ในนี้  
> หยางจะส่งไฟล์ `.env` ให้ทุกคนทาง Line/Discord แทน

> ⚠️ **ไฟล์ `routes/web.php`** ทุกคนต้องแก้ → มีโอกาส conflict สูง  
> แนะนำให้แต่ละคนเขียน route ไว้ในส่วนที่แบ่งไว้ชัดเจน โดยใส่ comment ชื่อคนกำกับ

> 💡 **ก่อน push ทุกครั้ง** ให้รัน `php artisan serve` ทดสอบว่าโค้ดทำงานได้ก่อน
