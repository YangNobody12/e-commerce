@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

{{-- สรุปข้อมูล --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">ผู้ใช้ทั้งหมด</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_users']) }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">สินค้าทั้งหมด</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_products']) }}</h2>
                    </div>
                    <i class="bi bi-box fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">คำสั่งซื้อ</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_orders']) }}</h2>
                    </div>
                    <i class="bi bi-receipt fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">รายได้รวม</h6>
                        <h2 class="mb-0">฿{{ number_format($stats['total_revenue'], 0) }}</h2>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- คำสั่งซื้อล่าสุด --}}
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> คำสั่งซื้อล่าสุด</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>เลขที่</th>
                            <th>ลูกค้า</th>
                            <th>ยอด</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_orders'] as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-danger">฿{{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_color }}">{{ $order->status_thai }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">ยังไม่มีคำสั่งซื้อ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- สมาชิกใหม่ --}}
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> สมาชิกใหม่</h5>
            </div>
            <div class="card-body">
                @forelse($stats['recent_users'] as $user)
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 40px; height: 40px; font-size: 14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }} ms-auto">
                        {{ $user->role }}
                    </span>
                </div>
                @empty
                <p class="text-center text-muted">ยังไม่มีสมาชิก</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ข้อมูลเพิ่มเติม --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5>{{ $stats['total_categories'] }}</h5>
                        <p class="text-muted">หมวดหมู่</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['pending_orders'] }}</h5>
                        <p class="text-muted">รอดำเนินการ</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['total_users'] }}</h5>
                        <p class="text-muted">สมาชิกทั้งหมด</p>
                    </div>
                    <div class="col-md-3">
                        <h5>{{ $stats['total_products'] }}</h5>
                        <p class="text-muted">สินค้าทั้งหมด</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection