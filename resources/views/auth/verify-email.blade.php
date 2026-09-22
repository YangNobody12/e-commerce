<x-guest-layout>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-info-subtle text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-envelope-check-fill fs-1"></i>
                        </div>
                        <h3 class="fw-bold">ยืนยันอีเมลของคุณ</h3>
                        <p class="text-muted small">ขอบคุณที่สมัครสมาชิก! กรุณาตรวจสอบอีเมลของคุณและคลิกลิงก์ยืนยันที่ส่งไป</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success py-2 small mb-4">
                            <i class="bi bi-check-circle me-1"></i> ลิงก์ยืนยันใหม่ได้ถูกส่งไปยังที่อยู่อีเมลของคุณแล้ว
                        </div>
                    @endif

                    <div class="d-flex flex-column gap-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 fw-bold">
                                ส่งอีเมลยืนยันอีกครั้ง <i class="bi bi-send ms-1"></i>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-muted small">
                                <i class="bi bi-box-arrow-right me-1"></i> ออกจากระบบ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
