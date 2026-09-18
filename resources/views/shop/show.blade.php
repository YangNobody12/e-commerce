@extends('layouts.app')

@section('title', 'รายละเอียดสินค้า - E-Commerce')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/shop') }}">สินค้า</a></li>
            <li class="breadcrumb-item active">ชื่อสินค้า</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- รูปสินค้า --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/600x500" class="card-img-top" alt="สินค้า">
            </div>
        </div>

        {{-- ข้อมูลสินค้า --}}
        <div class="col-md-6">
            <span class="badge bg-secondary mb-2">หมวดหมู่</span>
            <h1 class="fw-bold">ชื่อสินค้า</h1>
            <p class="product-price fs-2">฿ 999</p>
            
            <div class="mb-3">
                <span class="badge bg-success">มีสินค้า (50 ชิ้น)</span>
            </div>

            <p class="text-muted">
                รายละเอียดสินค้า... Lorem ipsum dolor sit amet consectetur adipisicing elit.
            </p>

            <hr>

            <form action="#" method="POST">
                @csrf
                <div class="d-flex align-items-center gap-3 mb-4">
                    <label class="fw-bold">จำนวน:</label>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">-</button>
                        <input type="number" class="form-control text-center" name="quantity" value="1" min="1" id="qty">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-add-cart btn-lg w-100">
                    <i class="bi bi-cart-plus"></i> เพิ่มลงตะกร้า
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}
function decreaseQty() {
    let qty = document.getElementById('qty');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
@endpush
