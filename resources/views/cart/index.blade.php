@extends('layouts.app')

@section('title', 'ตะกร้าสินค้า')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart3"></i> ตะกร้าสินค้า</h2>

    @if($cartItems->count() > 0)
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">สินค้า</th>
                                <th>ราคาต่อหน่วย</th>
                                <th style="width: 160px;">จำนวน</th>
                                <th>รวม</th>
                                <th class="pe-4 text-end">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            @php
                                $img = $item->product->image 
                                    ? (str_starts_with($item->product->image, 'http') ? $item->product->image : asset($item->product->image))
                                    : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500&auto=format&fit=crop&q=60';
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $img }}" width="60" height="60" 
                                             class="rounded me-3" style="object-fit: cover;">
                                        <div>
                                            <a href="{{ url('/shop/' . $item->product->slug) }}" class="text-dark fw-bold text-decoration-none">
                                                {{ $item->product->name }}
                                            </a>
                                            <br>
                                            <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>฿{{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                               min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm text-center" style="width: 75px;"
                                               onchange="this.form.submit()">
                                        <small class="text-muted ms-2">ชิ้น</small>
                                    </form>
                                </td>
                                <td class="fw-bold text-danger">
                                    ฿{{ number_format($item->quantity * $item->product->price, 2) }}
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('ต้องการลบสินค้านี้ออกจากตะกร้า?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="ลบรายการนี้">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- สรุปยอด --}}
        <div class="row mt-4">
            <div class="col-md-5 col-lg-4 ms-auto">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">สรุปคำสั่งซื้อ</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>จำนวนสินค้า:</span>
                            <span class="fw-bold">{{ $cartItems->sum('quantity') }} ชิ้น</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">ยอดรวม:</span>
                            <span class="fw-bold fs-5 text-danger">฿{{ number_format($total, 2) }}</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-add-cart w-100 py-2 shadow-sm">
                            <i class="bi bi-credit-card"></i> ดำเนินการสั่งซื้อ
                        </a>
                        <a href="{{ url('/shop') }}" class="btn btn-link text-decoration-none w-100 mt-2 text-muted">
                            <i class="bi bi-arrow-left"></i> เลือกซื้อสินค้าต่อ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm border-0 text-center py-5" style="border-radius: 12px;">
            <div class="card-body">
                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 fw-bold text-muted">ตะกร้าของคุณยังว่างเปล่า</h4>
                <p class="text-muted">เลือกสินค้าที่คุณถูกใจและเพิ่มลงในตะกร้าได้เลย</p>
                <a href="{{ url('/shop') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">
                    <i class="bi bi-bag"></i> ไปที่หน้าร้านค้า
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
