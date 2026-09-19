@extends('layouts.app')

@section('title', 'โปรไฟล์ของฉัน')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="bi bi-person-circle"></i> โปรไฟล์ของฉัน</h3>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> แก้ไข
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">ชื่อ:</div>
                        <div class="col-sm-9">{{ $user->name }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">อีเมล:</div>
                        <div class="col-sm-9">{{ $user->email }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">เบอร์โทร:</div>
                        <div class="col-sm-9">{{ $user->phone ?? 'ยังไม่ได้ระบุ' }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">ที่อยู่:</div>
                        <div class="col-sm-9">{{ $user->address ?? 'ยังไม่ได้ระบุ' }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">บทบาท:</div>
                        <div class="col-sm-9">
                            @if($user->isAdmin())
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold text-muted">สมัครเมื่อ:</div>
                        <div class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <hr>
                    <a href="{{ route('profile.password') }}" class="btn btn-outline-warning">
                        <i class="bi bi-key"></i> เปลี่ยนรหัสผ่าน
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection