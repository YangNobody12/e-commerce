@extends('layouts.app')

@section('title', 'สินค้าทั้งหมด - E-Commerce')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar: Filter --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-bold mb-0">กรองสินค้า</h5>
                        @if($selectedCategory || $minPrice || $maxPrice)
                            <a href="{{ url('/shop') }}" class="btn btn-sm btn-link text-danger text-decoration-none p-0">ล้างตัวกรอง</a>
                        @endif
                    </div>
                    <hr>
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-grid"></i> หมวดหมู่สินค้า</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="{{ url('/shop') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ empty($selectedCategory) ? 'fw-bold active' : '' }}" style="{{ empty($selectedCategory) ? 'background-color: #667eea; border-color: #667eea;' : '' }}">
                            <span>ทั้งหมด</span>
                            <span class="badge {{ empty($selectedCategory) ? 'bg-light text-dark' : 'bg-secondary' }} rounded-pill">10</span>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ url('/shop?category=' . $cat['slug']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $selectedCategory === $cat['slug'] ? 'fw-bold active' : '' }}" style="{{ $selectedCategory === $cat['slug'] ? 'background-color: #667eea; border-color: #667eea;' : '' }}">
                                <span>{{ $cat['name'] }}</span>
                                <span class="badge {{ $selectedCategory === $cat['slug'] ? 'bg-light text-dark' : 'bg-secondary' }} rounded-pill">{{ $cat['count'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    
                    <hr>
                    <h6 class="fw-bold mb-3"><i class="bi bi-cash-stack"></i> ช่วงราคา</h6>
                    <form method="GET" action="{{ url('/shop') }}">
                        @if($selectedCategory)
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        @if($sort)
                            <input type="hidden" name="sort" value="{{ $sort }}">
                        @endif
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small text-muted">ต่ำสุด (฿)</label>
                                <input type="number" class="form-control form-control-sm" placeholder="0" name="min_price" value="{{ $minPrice }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">สูงสุด (฿)</label>
                                <input type="number" class="form-control form-control-sm" placeholder="1000" name="max_price" value="{{ $maxPrice }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark w-100 mt-3 rounded-pill">
                            <i class="bi bi-funnel"></i> นำไปใช้
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="col-md-9">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h2 class="section-title mb-0">สินค้าทั้งหมด</h2>
                    <p class="text-muted small mt-1 mb-0">พบสินค้าทั้งหมด {{ count($products) }} รายการ</p>
                </div>
                <form method="GET" action="{{ url('/shop') }}" class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    @if($minPrice)
                        <input type="hidden" name="min_price" value="{{ $minPrice }}">
                    @endif
                    @if($maxPrice)
                        <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                    @endif
                    <label class="small text-muted text-nowrap">เรียงตาม:</label>
                    <select class="form-select form-select-sm w-auto" name="sort" onchange="this.form.submit()">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>ล่าสุด</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>ราคา: ต่ำ → สูง</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>ราคา: สูง → ต่ำ</option>
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>ชื่อ: ก → ฮ</option>
                    </select>
                </form>
            </div>

            @if(count($products) === 0)
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-info-circle fs-1"></i>
                    <h5 class="mt-3">ไม่พบสินค้าตามเงื่อนไขที่เลือก</h5>
                    <p class="text-muted">กรุณาลองปรับเปลี่ยนตัวกรองใหม่อีกครั้ง</p>
                    <a href="{{ url('/shop') }}" class="btn btn-primary rounded-pill btn-sm">ดูสินค้าทั้งหมด</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="card product-card h-100 d-flex flex-column">
                                <div style="height: 220px; overflow: hidden; background: #f8f9fa;">
                                    <img src="{{ $product['image'] }}" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="{{ $product['name'] }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2">{{ $product['category'] }}</span>
                                    <h5 class="card-title fs-6 fw-bold flex-grow-1">{{ $product['name'] }}</h5>
                                    <p class="product-price mb-3">฿ {{ number_format($product['price'], 2) }}</p>
                                    <div class="d-flex gap-2 mt-auto">
                                        <a href="{{ url('/shop/' . $product['slug']) }}" class="btn btn-outline-dark btn-sm flex-fill">ดูรายละเอียด</a>
                                        <a href="{{ url('/shop/' . $product['slug']) }}" class="btn btn-add-cart btn-sm">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
