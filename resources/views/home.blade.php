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
