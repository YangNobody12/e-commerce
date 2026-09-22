@extends('layouts.app')

@section('title', 'ชำระเงิน - E-Commerce')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">ตะกร้าสินค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">ชำระเงิน</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold"><i class="bi bi-credit-card"></i> ดำเนินการสั่งซื้อ & ชำระเงิน</h2>

    <form action="{{ route('orders.place') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- ข้อมูลจัดส่ง --}}
            <div class="col-md-7">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4"><i class="bi bi-geo-alt"></i> ข้อมูลการจัดส่ง</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ชื่อ-นามสกุล ผู้รับ <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                   value="{{ old('shipping_name', auth()->user()->name) }}" required>
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">เบอร์โทรศัพท์ติดต่อ <span class="text-danger">*</span></label>
                            <input type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                   value="{{ old('shipping_phone', auth()->user()->phone) }}" placeholder="เช่น 0812345678" required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ที่อยู่สำหรับจัดส่ง <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                      rows="3" placeholder="บ้านเลขที่, ถนน, ตำบล, อำเภอ, จังหวัด, รหัสไปรษณีย์" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">หมายเหตุถึงผู้จัดส่ง (ถ้ามี)</label>
                            <textarea name="note" class="form-control" rows="2" 
                                      placeholder="เช่น ฝากไว้กับป้อมยาม, โทรแจ้งก่อนส่ง">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- สรุปคำสั่งซื้อ --}}
            <div class="col-md-5">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px; border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="bi bi-receipt"></i> สรุปคำสั่งซื้อ</h5>

                        <div class="mb-3">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <span class="fw-semibold">{{ $item->product->name }}</span>
                                    <br>
                                    <small class="text-muted">จำนวน: {{ $item->quantity }} x ฿{{ number_format($item->product->price, 2) }}</small>
                                </div>
                                <span class="fw-bold">฿{{ number_format($item->quantity * $item->product->price, 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>ยอดรวมสินค้า:</span>
                            <span>฿{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>ค่าจัดส่ง:</span>
                            <span>ฟรี</span>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">ยอดชำระสุทธิ:</span>
                            <span class="fw-bold fs-5 text-danger">฿{{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-add-cart w-100 btn-lg shadow-sm" 
                                onclick="return confirm('ยืนยันการสั่งซื้อสินค้า?')">
                            <i class="bi bi-check-circle-fill"></i> ยืนยันคำสั่งซื้อ
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-link text-decoration-none w-100 mt-2 text-muted">
                            <i class="bi bi-arrow-left"></i> ย้อนกลับไปแก้ไขตะกร้า
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
