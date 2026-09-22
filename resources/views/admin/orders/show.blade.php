@extends('admin.layouts.app')

@section('title', 'รายละเอียดคำสั่งซื้อ ' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left"></i> กลับไปรายการคำสั่งซื้อ
        </a>
        <h2 class="mb-0"><i class="bi bi-receipt"></i> คำสั่งซื้อ: {{ $order->order_number }}</h2>
    </div>
    <div>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex align-items-center gap-2">
            @csrf
            @method('PATCH')
            <label class="fw-bold text-nowrap">เปลี่ยนสถานะ:</label>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ กำลังดำเนินการ</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 จัดส่งแล้ว</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ ส่งถึงแล้ว</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ยกเลิก</option>
            </select>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-geo-alt"></i> ข้อมูลการจัดส่ง
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>ผู้รับ:</strong> {{ $order->shipping_name }}</p>
                <p class="mb-2"><strong>เบอร์โทรศัพท์:</strong> {{ $order->shipping_phone }}</p>
                <p class="mb-2"><strong>ที่อยู่จัดส่ง:</strong> {{ $order->shipping_address }}</p>
                @if($order->note)
                    <p class="mb-0 text-muted"><strong>หมายเหตุ:</strong> {{ $order->note }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-info-circle"></i> ข้อมูลลูกค้า & วันที่
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>ผู้สั่งซื้อ:</strong> {{ $order->user->name ?? 'ไม่ระบุ' }}</p>
                <p class="mb-2"><strong>อีเมล:</strong> {{ $order->user->email ?? 'ไม่ระบุ' }}</p>
                <p class="mb-2"><strong>วันที่สั่งซื้อ:</strong> {{ $order->created_at->format('d/m/Y H:i น.') }}</p>
                <p class="mb-0"><strong>สถานะปัจจุบัน:</strong> <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_thai }}</span></p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">
        <i class="bi bi-box"></i> รายการสินค้าในคำสั่งซื้อ
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ชื่อสินค้า</th>
                        <th class="text-center">ราคาต่อหน่วย</th>
                        <th class="text-center">จำนวน</th>
                        <th class="pe-4 text-end">ยอดรวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-semibold">{{ $item->product_name }}</span>
                            @if($item->product)
                                <br><small class="text-muted">รหัสสินค้า ID: #{{ $item->product_id }}</small>
                            @endif
                        </td>
                        <td class="text-center">฿{{ number_format($item->price, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="pe-4 text-end fw-bold">฿{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="3" class="text-end fw-bold fs-5">ยอดรวมสุทธิ:</td>
                        <td class="pe-4 text-end fw-bold fs-5 text-danger">฿{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
