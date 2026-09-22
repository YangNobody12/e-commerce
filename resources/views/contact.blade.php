@extends('layouts.app')

@section('title', 'ติดต่อเรา - E-Commerce')

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">หน้าแรก</a></li>
            <li class="breadcrumb-item active" aria-current="page">ติดต่อเรา</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-6 mb-2">ติดต่อเรา</h1>
        <p class="text-muted">ยินดีให้คำปรึกษาและตอบทุกข้อสงสัย ติดต่อทีมผู้พัฒนาของเราได้ตลอดเวลา</p>
    </div>

    {{-- Team Section --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-people-fill text-primary me-2"></i>ทีมงานผู้พัฒนา (Development Team)
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 justify-content-center">
                {{-- หยาง --}}
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border text-center p-3 hover-shadow transition">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="bi bi-person-gear"></i>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">หยาง 👑</h5>
                        <p class="badge bg-primary text-wrap mb-2">Team Lead / DevOps & Auth</p>
                        <p class="text-muted small mb-0">ระบบ Login/Register, ตั้งค่าโปรเจกต์, เชื่อมต่อ Supabase, และ Merge Branch</p>
                    </div>
                </div>

                {{-- พลับ --}}
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border text-center p-3 hover-shadow transition">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info rounded-circle" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="bi bi-palette"></i>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">พลับ</h5>
                        <p class="badge bg-info text-dark text-wrap mb-2">Frontend Developer</p>
                        <p class="text-muted small mb-0">หน้าเว็บหลัก (Home, Shop Listing, Product Detail, Layout และ Navbar/Footer)</p>
                    </div>
                </div>

                {{-- โชค --}}
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border text-center p-3 hover-shadow transition">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning-emphasis rounded-circle" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="bi bi-box-seam"></i>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">โชค</h5>
                        <p class="badge bg-warning text-dark text-wrap mb-2">Product Management</p>
                        <p class="text-muted small mb-0">ระบบจัดการสินค้า (CRUD Products) และจัดการหมวดหมู่สินค้า (Categories)</p>
                    </div>
                </div>

                {{-- กวาง --}}
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border text-center p-3 hover-shadow transition">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="bi bi-cart-check"></i>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">กวาง</h5>
                        <p class="badge bg-success text-wrap mb-2">Cart & Order System</p>
                        <p class="text-muted small mb-0">ระบบตะกร้าสินค้า (Cart), ระบบสั่งซื้อสินค้า (Checkout) และตัดสต็อกสินค้า</p>
                    </div>
                </div>

                {{-- ปิงปอง --}}
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border text-center p-3 hover-shadow transition">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle" style="width: 70px; height: 70px; font-size: 2rem;">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-1">ปิงปอง</h5>
                        <p class="badge bg-danger text-wrap mb-2">User Profile & Admin</p>
                        <p class="text-muted small mb-0">จัดการโปรไฟล์ผู้ใช้, แดชบอร์ดสรุปสถิติ Admin และระบบจัดการผู้ใช้งาน (Users)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Info & Form --}}
    <div class="row g-4">
        {{-- Contact Info Cards --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">ข้อมูลการติดต่อ</h5>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-3">
                                <i class="bi bi-geo-alt fs-4"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">ที่ตั้ง</h6>
                            <p class="text-muted small mb-0">มหาวิทยาลัยราชภัฏเชียงใหม่<br>อำเภอเมือง จังหวัดเชียงใหม่ 50300</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <span class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-3 p-3">
                                <i class="bi bi-envelope fs-4"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">อีเมล</h6>
                            <p class="text-muted small mb-0">contact@example.com<br>support@ecommerce.local</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <span class="d-inline-flex align-items-center justify-content-center bg-info text-white rounded-3 p-3">
                                <i class="bi bi-telephone fs-4"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">เบอร์โทรศัพท์</h6>
                            <p class="text-muted small mb-0">02-xxx-xxxx, 053-xxx-xxxx</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <span class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-3 p-3">
                                <i class="bi bi-clock fs-4"></i>
                            </span>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">เวลาทำการ</h6>
                            <p class="text-muted small mb-0">จันทร์ - ศุกร์: 08:30 - 17:00 น.<br>เสาร์ - อาทิตย์: ปิดทำการ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">ส่งข้อความถึงเรา</h5>
                    <p class="text-muted small mb-4">กรอกข้อมูลในแบบฟอร์มด้านล่างเพื่อส่งข้อความถึงทีมงาน</p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">อีเมล <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">หัวข้อเรื่อง</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" placeholder="เรื่องที่ต้องการติดต่อ...">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">ข้อความ <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4" required placeholder="รายละเอียดข้อความของคุณ...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="bi bi-send me-1"></i> ส่งข้อความ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
