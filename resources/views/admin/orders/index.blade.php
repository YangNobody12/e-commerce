@extends('admin.layouts.app')

@section('title', 'จัดการคำสั่งซื้อ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> จัดการคำสั่งซื้อ</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">เลขที่</th>
                        <th>ลูกค้า</th>
                        <th>ยอดรวม</th>
                        <th>สถานะคำสั่งซื้อ</th>
                        <th>วันที่สั่ง</th>
                        <th class="pe-4 text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $order->order_number }}</td>
                        <td>
                            <span>{{ $order->user->name ?? '-' }}</span>
                            <br>
                            <small class="text-muted">{{ $order->shipping_phone }}</small>
                        </td>
                        <td class="text-danger fw-bold">฿{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm border-{{ $order->status_color }} fw-semibold" style="width: auto;" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ กำลังดำเนินการ</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 จัดส่งแล้ว</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ ส่งถึงแล้ว</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ยกเลิก</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info text-white" title="ดูรายละเอียด">
                                <i class="bi bi-eye"></i> ดูข้อมูล
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">ยังไม่มีคำสั่งซื้อในระบบ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
