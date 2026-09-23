@extends('admin.layouts.app')

@section('title', 'แก้ไขหมวดหมู่')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> แก้ไขหมวดหมู่: {{ $category->name }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> กลับ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">ชื่อหมวดหมู่ <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">คำอธิบาย</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">รูปหมวดหมู่</label>
                @if($category->image_url)
                    <div class="mb-2">
                        <img src="{{ $category->image_url }}" class="img-thumbnail" width="150">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">ถ้าไม่เลือกรูปใหม่ จะใช้รูปเดิม</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> บันทึกการแก้ไข
            </button>
        </form>
    </div>
</div>
@endsection
