@extends('admin.layouts.app')

@section('title', 'แก้ไขผู้ใช้')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> แก้ไขผู้ใช้: {{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">ชื่อ <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">อีเมล <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">เบอร์โทร</label>
                        <input type="tel" name="phone" class="form-control"
                               value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">บทบาท <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <hr>
                    <h5 class="text-muted">เปลี่ยนรหัสผ่าน (ไม่บังคับ)</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">รหัสผ่านใหม่</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">เว้นว่างถ้าไม่ต้องการเปลี่ยน</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> บันทึก
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection