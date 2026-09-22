@extends('layouts.app')

@section('title', $product->name . ' - E-Commerce')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/shop') }}">สินค้า</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ url('/shop?category=' . $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5 mt-2">
        {{-- รูปสินค้า --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px;">
                @php
                    $prodImg = $product->image 
                        ? (str_starts_with($product->image, 'http') ? $product->image : asset($product->image))
                        : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500&auto=format&fit=crop&q=60';
                @endphp
                <img src="{{ $prodImg }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 480px; object-fit: cover;">
            </div>
        </div>

        {{-- ข้อมูลสินค้า --}}
        <div class="col-md-6">
            @if($product->category)
                <a href="{{ url('/shop?category=' . $product->category->slug) }}" class="badge bg-primary-subtle text-primary text-decoration-none px-3 py-2 fs-6 mb-2">
                    <i class="bi bi-tag-fill"></i> {{ $product->category->name }}
                </a>
            @endif
            <h1 class="fw-bold mt-2">{{ $product->name }}</h1>
            <p class="product-price fs-2 my-3">฿ {{ number_format($product->price, 2) }}</p>
            
            <div class="mb-3">
                @if($product->stock > 0)
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                        <i class="bi bi-check-circle-fill"></i> มีสินค้าพร้อมส่ง ({{ $product->stock }} ชิ้น)
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                        <i class="bi bi-x-circle-fill"></i> สินค้าหมด
                    </span>
                @endif
            </div>

            <p class="text-muted lead fs-6 lh-base my-4">
                {{ $product->description }}
            </p>

            <hr>

            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label class="fw-bold">จำนวน:</label>
                        <div class="input-group" style="width: 140px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">-</button>
                            <input type="number" class="form-control text-center fw-bold" name="quantity" value="1" min="1" max="{{ $product->stock }}" id="qty">
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                        </div>
                        <span class="text-muted small">ชิ้น</span>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-add-cart btn-lg flex-grow-1 shadow-sm">
                            <i class="bi bi-cart-plus-fill"></i> เพิ่มลงตะกร้า
                        </button>
                        <a href="{{ url('/shop') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> กลับหน้าร้าน
                        </a>
                    </div>
                </form>
            @else
                <div class="alert alert-secondary">
                    สินค้าชิ้นนี้หมดสต็อกชั่วคราว ไม่สามารถสั่งซื้อได้ในขณะนี้
                </div>
                <a href="{{ url('/shop') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left"></i> กลับหน้าร้าน
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    let max = {{ $product->stock }};
    if (parseInt(qty.value) < max) {
        qty.value = parseInt(qty.value) + 1;
    }
}
function decreaseQty() {
    let qty = document.getElementById('qty');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
@endpush
