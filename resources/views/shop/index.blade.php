@extends('layouts.app')

@section('title', 'สินค้าทั้งหมด - E-Commerce')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar: Filter --}}
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">กรองสินค้า</h5>
                    <hr>
                    <h6>หมวดหมู่</h6>
                    <ul class="list-unstyled">
                        {{-- TODO: Loop จาก categories --}}
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-dark">เสื้อผ้า (10)</a>
                        </li>
                    </ul>
                    
                    <hr>
                    <h6>ช่วงราคา</h6>
                    <form>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="ต่ำสุด" name="min_price">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" placeholder="สูงสุด" name="max_price">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark w-100 mt-2">กรอง</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">สินค้าทั้งหมด</h2>
                <select class="form-select w-auto">
                    <option>เรียงตาม: ล่าสุด</option>
                    <option>ราคา: ต่ำ → สูง</option>
                    <option>ราคา: สูง → ต่ำ</option>
                    <option>ชื่อ: ก → ฮ</option>
                </select>
            </div>

            <div class="row g-4">
                {{-- TODO: Loop จาก products --}}
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="สินค้า">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">หมวดหมู่</span>
                            <h5 class="card-title">ชื่อสินค้า</h5>
                            <p class="product-price">฿ 999</p>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-dark flex-fill">ดูรายละเอียด</a>
                                <button class="btn btn-add-cart">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- เพิ่มสินค้าอื่นๆ -->
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{-- TODO: {{ $products->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
