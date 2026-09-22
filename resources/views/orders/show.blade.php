@extends('layouts.app')

@section('title', 'คำสั่งซื้อ ' . $order->order_number . ' - E-Commerce')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> กลับไปหน้ารายการคำสั่งซื้อ
        </a>
        <span class="badge bg-{{ $order->status_color }} fs-6 px-3 py-2">
            สถานะ: {{ $order->status_thai }}
        </span>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold"><i class="bi bi-receipt"></i> ใบสั่งซื้อเลขที่: {{ $order->order_number }}</h4>
                <small class="text-muted">วันที่สั่งซื้อ: {{ $order->created_at->format('d/m/Y H:i น.') }}</small>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded h-100">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt"></i> ข้อมูลที่อยู่จัดส่ง</h6>
                        <p class="mb-1"><strong>ผู้รับ:</strong> {{ $order->shipping_name }}</p>
                        <p class="mb-1"><strong>เบอร์โทร:</strong> {{ $order->shipping_phone }}</p>
                        <p class="mb-1"><strong>ที่อยู่:</strong> {{ $order->shipping_address }}</p>
                        @if($order->note)
                            <p class="mb-0 mt-2 text-muted"><strong>หมายเหตุ:</strong> {{ $order->note }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded h-100">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle"></i> ข้อมูลการสั่งซื้อ</h6>
                        <p class="mb-1"><strong>ลูกค้า:</strong> {{ $order->user->name ?? '-' }} ({{ $order->user->email ?? '-' }})</p>
                        <p class="mb-1"><strong>วิธีการชำระ:</strong> เก็บเงินปลายทาง / ชำระแล้ว</p>
                        <p class="mb-0"><strong>ปรับปรุงล่าสุด:</strong> {{ $order->updated_at->format('d/m/Y H:i น.') }}</p>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3">รายการสินค้า</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>สินค้า</th>
                            <th class="text-center">ราคาต่อหน่วย</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-end">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $item->product_name }}</span>
                                @if($item->product)
                                    <br><small><a href="{{ url('/shop/' . $item->product->slug) }}" class="text-muted text-decoration-none">ดูหน้าสินค้า</a></small>
                                @endif
                            </td>
                            <td class="text-center">฿{{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end fw-semibold">฿{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5">ยอดรวมทั้งหมด:</td>
                            <td class="text-end fw-bold fs-5 text-danger">฿{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
