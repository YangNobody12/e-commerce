<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">
        {{-- Sidebar --}}
        <div class="admin-sidebar d-flex flex-column p-3 bg-dark text-white" style="width: 250px;">
            <a href="{{ url('/admin') }}" class="text-white text-decoration-none mb-4">
                <h4><i class="bi bi-gear"></i> Admin Panel</h4>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/products') }}">
                        <i class="bi bi-box"></i> สินค้า
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/categories') }}">
                        <i class="bi bi-tags"></i> หมวดหมู่
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/orders') }}">
                        <i class="bi bi-receipt"></i> คำสั่งซื้อ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/admin/users') }}">
                        <i class="bi bi-people"></i> ผู้ใช้
                    </a>
                </li>
                <hr class="text-white">
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="{{ url('/') }}">
                        <i class="bi bi-arrow-left"></i> กลับหน้าเว็บ
                    </a>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <span class="navbar-text">สวัสดี, {{ Auth::user()->name ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">ออกจากระบบ</button>
                </form>
            </nav>

            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
