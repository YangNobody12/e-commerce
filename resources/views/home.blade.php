@extends('layouts.app')

@section('title', 'หน้าแรก - E-Commerce')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section text-center">
        <div class="container">
            <h1>ยินดีต้อนรับสู่ร้านค้าออนไลน์</h1>
            <p class="lead mt-3">สินค้าคุณภาพ ราคาดี จัดส่งรวดเร็ว มีให้เลือกครบทุกหมวดหมู่</p>
            <a href="{{ url('/shop') }}" class="btn btn-light btn-lg mt-3 px-5 rounded-pill shadow-sm">
                <i class="bi bi-bag"></i> เลือกซื้อสินค้าทั้งหมด
            </a>
        </div>
    </section>

    {{-- หมวดหมู่สินค้า --}}
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">หมวดหมู่สินค้า</h2>
            <div class="row g-4 mt-2">
                @foreach($categories as $category)
                    <div class="col-md-4 col-lg-3 col-sm-6">
                        <a href="{{ url('/shop?category=' . $category->slug) }}" class="text-decoration-none">
                            <div class="category-card shadow-sm h-100">
                                @php
                                    $catImg = $category->image 
                                        ? (str_starts_with($category->image, 'http') ? $category->image : asset($category->image))
                                        : 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=500&auto=format&fit=crop&q=60';
                                @endphp
                                <img src="{{ $catImg }}" alt="{{ $category->name }}" style="height: 180px; object-fit: cover; width: 100%;">
                                <div class="overlay">
                                    <h5 class="mb-0 fw-bold">{{ $category->name }}</h5>
                                    <small class="text-white-50">{{ $category->products_count ?? 0 }} รายการ</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- สินค้าแนะนำ --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">สินค้าแนะนำ</h2>
                <a href="{{ url('/shop') }}" class="btn btn-outline-primary rounded-pill">ดูสินค้าทั้งหมด <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4 mt-2">
                @foreach($featuredProducts as $item)
                    @php
                        $prodImg = $item->image 
                            ? (str_starts_with($item->image, 'http') ? $item->image : asset($item->image))
                            : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500&auto=format&fit=crop&q=60';
                    @endphp
                    <div class="col-md-6 col-lg-3 col-sm-6">
                        <div class="card product-card h-100 d-flex flex-column">
                            <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                                <img src="{{ $prodImg }}" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="{{ $item->name }}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2">{{ $item->category->name ?? 'ทั่วไป' }}</span>
                                <h5 class="card-title fs-6 fw-bold flex-grow-1">{{ $item->name }}</h5>
                                <p class="product-price mb-3">฿ {{ number_format($item->price, 2) }}</p>
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ url('/shop/' . $item->slug) }}" class="btn btn-outline-dark btn-sm flex-fill">ดูรายละเอียด</a>
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-add-cart btn-sm" title="เพิ่มลงตะกร้า">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
