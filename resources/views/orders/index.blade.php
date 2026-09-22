@extends('layouts.app')

@section('title', 'ประวัติคำสั่งซื้อ - E-Commerce')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="bi bi-receipt"></i> ประวัติคำสั่งซื้อของฉัน</h2>
        <a href="{{ url('/shop') }}" class="btn btn-outline-primary rounded-pill btn-sm">
            <i class="bi bi-bag"></i> ช้อปสินค้าต่อ
        </a>
    </div>

    @forelse($orders as $order)
    <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="mb-2 mb-md-0">
                    <span class="fw-bold fs-5 text-dark">{{ $order->order_number }}</span>
                    <br>
                    <small class="text-muted"><i class="bi bi-calendar-event"></i> วันที่สั่ง: {{ $order->created_at->format('d/m/Y H:i น.') }}</small>
                </div>
                <div class="text-md-end">
                    <span class="badge bg-{{ $order->status_color }} fs-6 px-3 py-1 mb-2">{{ $order->status_thai }}</span>
                    <br>
                    <span class="fw-bold text-danger fs-5">฿{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            <hr class="my-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">ผู้รับ: {{ $order->shipping_name }} ({{ $order->shipping_phone }})</small>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    ดูรายละเอียด <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card shadow-sm border-0 text-center py-5" style="border-radius: 12px;">
        <div class="card-body">
            <i class="bi bi-receipt-cutoff text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 fw-bold text-muted">คุณยังไม่มีประวัติคำสั่งซื้อ</h4>
            <p class="text-muted">เมื่อคุณทำการสั่งซื้อสินค้า รายการคำสั่งซื้อจะปรากฏที่นี่</p>
            <a href="{{ url('/shop') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">
                <i class="bi bi-bag"></i> เริ่มต้นเลือกซื้อสินค้า
            </a>
        </div>
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
