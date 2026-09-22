# 📋 สรุปสิ่งที่ต้องส่ง & เช็คลิสต์การส่งงาน (Submission Checklist)
**โครงการ:** ระบบร้านค้าออนไลน์ (E-Commerce Web Application)  
**ทีมผู้พัฒนา:** หยาง, พลับ, โชค, กวาง, ปิงปอง  

---

## 📌 ตารางเช็คลิสต์สิ่งที่ต้องส่ง (ครบถ้วนตามข้อกำหนด 5 ข้อ)

| ข้อ | สิ่งที่ต้องส่ง | สถานะ | ไฟล์และเอกสารที่เตรียมไว้ให้ในโปรเจกต์ |
|:---:|---|:---:|---|
| **1** | **ซอร์สโค้ดโปรแกรม (Source Code) พร้อมไฟล์ฐานข้อมูล/สคริปต์สร้างฐานข้อมูล** |  พร้อมส่ง | • ซอร์สโค้ดทั้งหมดในโปรเจกต์ (Laravel 11)<br>• ไฟล์ฐานข้อมูล SQL: [`docs/database.sql`](file:///Users/yangnobody/Desktop/code/e-commerce/docs/database.sql)<br>• สคริปต์ Migration: `database/migrations/`<br>• สคริปต์ Seeder: `database/seeders/` |
| **2** | **เอกสารออกแบบระบบ ได้แก่ ER-Diagram และคำอธิบายโครงสร้างตาราง** |  พร้อมส่ง | • เอกสารฉบับสมบูรณ์: [`docs/SYSTEM_DESIGN_AND_ERD.md`](file:///Users/yangnobody/Desktop/code/e-commerce/docs/SYSTEM_DESIGN_AND_ERD.md)<br>• แผนภาพ ER-Diagram (Mermaid Format)<br>• Data Dictionary คำอธิบายตารางครบทั้ง 6 ตาราง |
| **3** | **คู่มือการใช้งานโปรแกรม (User Manual) โดยสังเขป** |  พร้อมส่ง | • เอกสารฉบับสมบูรณ์: [`docs/USER_MANUAL.md`](file:///Users/yangnobody/Desktop/code/e-commerce/docs/USER_MANUAL.md)<br>• ข้อมูลบัญชีทดสอบ (Admin / User)<br>• ขั้นตอนการใช้งานฝั่งลูกค้า & ผู้ดูแลระบบอย่างละเอียด |
| **4** | **การนำเสนอผลงานหน้าชั้นเรียน พร้อมสาธิตการทำงานจริง (Live Demo)** |  พร้อมส่ง | • คู่มือและสคริปต์นำเสนอ: [`docs/PRESENTATION_AND_DEMO_GUIDE.md`](file:///Users/yangnobody/Desktop/code/e-commerce/docs/PRESENTATION_AND_DEMO_GUIDE.md)<br>• โครงร่างสไลด์ 10 หน้า<br>• สคริปต์บทพูดและขั้นตอนสาธิต Live Demo แบ่งตามคน<br>• แนวทางการตอบคำถามอาจารย์ (Q&A) |
| **5** | **สร้างโฟลเดอร์กลุ่มตนเองในไดรฟ์ที่ให้ และส่งข้อ 1-4 ในโฟลเดอร์กลุ่มตนเอง** | 📂 แนะนำโครงสร้างด้านล่าง | • ปฏิบัติตามแนวทางการจัดโครงสร้างโฟลเดอร์ใน Google Drive ด้านล่าง |

---

## 🗂 โครงสร้างโฟลเดอร์แนะนำสำหรับการส่งใน Google Drive (ข้อ 5)

ให้สร้างโฟลเดอร์ใน Google Drive ที่อาจารย์กำหนด โดยตั้งชื่อโฟลเดอร์ตามรูปแบบ:  
`กลุ่ม_[ชื่อกลุ่มหรือหมายเลขกลุ่ม]_ระบบร้านค้าออนไลน์_E-Commerce`

ภายในโฟลเดอร์ให้จัดไฟล์เป็นหมวดหมู่อย่างเป็นระเบียบดังนี้:

```text
📁 กลุ่ม_E-Commerce_ระบบร้านค้าออนไลน์/
│
├── 📁 1_SourceCode_and_Database/
│   ├── 📄 e-commerce-sourcecode.zip      <-- ซอร์สโค้ดโปรแกรมทั้งหมด (Zip ไฟล์โปรเจกต์ ยกเว้น vendor/node_modules)
│   ├── 📄 database.sql                   <-- ไฟล์ฐานข้อมูล (คัดลอกจาก docs/database.sql)
│   └── 📄 github_link.txt                <-- ลิงก์ Repository: https://github.com/YangNobody12/e-commerce
│
├── 📁 2_SystemDesign_and_ERD/
│   ├── 📄 SYSTEM_DESIGN_AND_ERD.pdf      <-- แปลง docs/SYSTEM_DESIGN_AND_ERD.md เป็น PDF
│   └── 🖼 erd_diagram.png                <-- รูปภาพแผนภาพ ER-Diagram
│
├── 📁 3_UserManual/
│   └── 📄 USER_MANUAL.pdf                <-- แปลง docs/USER_MANUAL.md เป็น PDF
│
├── 📁 4_Presentation_and_LiveDemo/
│   ├── 📊 Presentation_Slides.pptx       <-- สไลด์นำเสนอ (สร้างตามหัวข้อใน PRESENTATION_AND_DEMO_GUIDE.md)
│   ├── 📄 Presentation_Slides.pdf        <-- สไลด์นำเสนอเวอร์ชัน PDF
│   └── 📄 DEMO_SCRIPT.pdf                <-- สคริปต์ลำดับการสาธิต Live Demo สำหรับทีม
│
└── 📄 README.txt                         <-- สรุปรายชื่อสมาชิกในกลุ่มและข้อมูลเข้าสู่ระบบทดสอบ
```

---

## 🔑 ข้อมูลสำคัญสำหรับแนบในไฟล์ `README.txt`

```text
==================================================
โครงงาน: ระบบร้านค้าออนไลน์ (E-Commerce Web Application)
==================================================

รายชื่อสมาชิกในกลุ่ม:
1. หยาง - Team Lead / DevOps & Auth
2. พลับ - Frontend Developer
3. โชค - Product Management
4. กวาง - Cart & Order System
5. ปิงปอง - User Profile & Admin

ข้อมูลการเข้าสู่ระบบสำหรับทดสอบ (Credentials):
- URL ระบบ: http://127.0.0.1:8000
- บัญชีผู้ดูแลระบบ (Admin):
  Email: admin@example.com
  Password: password
- บัญชีผู้ใช้งานทั่วไป (User):
  Email: user@example.com
  Password: password

คำสั่งในการติดตั้งและเริ่มใช้งาน:
1. composer install
2. cp .env.example .env && php artisan key:generate
3. php artisan migrate --seed (หรือนำเข้าไฟล์ database.sql)
4. php artisan serve
==================================================
```
