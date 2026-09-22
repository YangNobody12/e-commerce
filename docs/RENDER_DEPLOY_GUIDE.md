# 🚀 คู่มือการ Deploy ระบบร้านค้าออนไลน์ Laravel บน Render (Render.com)

ระบบได้รับการเตรียมไฟล์สำหรับ Deploy บน Render ไว้อย่างสมบูรณ์แล้ว ประกอบด้วย:
- [`Dockerfile`](file:///Users/yangnobody/Desktop/code/e-commerce/Dockerfile): คอนฟิก PHP 8.2 + Apache + PostgreSQL Driver + Composer
- [`render.yaml`](file:///Users/yangnobody/Desktop/code/e-commerce/render.yaml): Blueprint สำหรับตั้งค่า Web Service และ Environment Variables อัตโนมัติ

---

## 🌟 วิธีที่ 1: Deploy ผ่าน Render Blueprint (แนะนำ - ง่ายที่สุด กดคลิกเดียวจบ)

1. เข้าเว็บไซต์ **[dashboard.render.com](https://dashboard.render.com)** แล้วล็อกอินด้วยบัญชี **GitHub** ของคุณ (`YangNobody12`)
2. คลิกปุ่ม **New +** ที่มุมขวาบน ➔ เลือก **Blueprint**
3. เลือก Repository: `YangNobody12/e-commerce` (Branch: `main`)
4. Render จะตรวจพบไฟล์ `render.yaml` และแสดงรายการตั้งค่าให้โดยอัตโนมัติ:
   - **Service Name:** `ecommerce-laravel`
   - **Runtime:** `Docker`
   - **Environment Variables:** เชื่อมต่อ Supabase PostgreSQL ครบถ้วนอัตโนมัติ
5. คลิกปุ่ม **Apply** ด้านล่าง
6. รอ Render ดำเนินการ Build Docker ประมาณ 2-4 นาที เมื่อขึ้นสถานะ **Live** คุณจะได้รับ URL เช่น `https://ecommerce-laravel-xxxx.onrender.com` ใช้งานได้ทันที!

---

## 🛠️ วิธีที่ 2: Deploy แบบ Web Service ทั่วไป (สร้างแบบ Manual)

หากต้องการสร้าง Service ทีละขั้นตอนด้วยตนเอง:

1. ที่ Dashboard ของ Render คลิกปุ่ม **New +** ➔ เลือก **Web Service**
2. เลือกเชื่อมต่อกับ Repository `YangNobody12/e-commerce`
3. ตั้งค่าพื้นฐาน:
   - **Name:** `ecommerce-laravel`
   - **Region:** `Singapore (Southeast Asia)`
   - **Branch:** `main`
   - **Language / Runtime:** เลือก **Docker**
   - **Instance Type:** เลือก **Free**
4. เลื่อนลงมาที่หัวข้อ **Environment Variables** แล้วกด **Add Environment Variable** ตามตารางนี้:

| Key | Value |
|---|---|
| `APP_NAME` | `E-Commerce` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:mw1fFfqJprCIsVs0+WO69yWtRHDjDftXxvmADLfwvSE=` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `aws-0-ap-northeast-1.pooler.supabase.com` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `postgres` |
| `DB_USERNAME` | `postgres.pjmoqicsfosybiovxsfb` |
| `DB_PASSWORD` | `okpkmyang12` |
| `DB_SCHEMA` | `public` |
| `DB_SSLMODE` | `require` |
| `SESSION_DRIVER` | `database` |

5. คลิกปุ่ม **Create Web Service** ด้านล่างสุด

---

## 📋 การตรวจสอบการทำงานหลัง Deploy สำเร็จ:

1. เปิด URL ที่ Render สร้างให้ (เช่น `https://ecommerce-laravel.onrender.com`)
2. ทดสอบเข้าสู่ระบบ:
   - **Admin:** `admin@example.com` / `password`
   - **User:** `user@example.com` / `password`
3. สั่งซื้อสินค้าและตรวจสอบข้อมูลในตะกร้าและฐานข้อมูล Supabase ได้อย่างสมบูรณ์
