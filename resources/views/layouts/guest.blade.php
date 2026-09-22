<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Commerce') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    {{-- Header / Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-shop text-primary"></i> E-Commerce
            </a>
            
            <div class="ms-auto">
                <a class="btn btn-outline-light btn-sm" href="{{ url('/') }}">
                    <i class="bi bi-arrow-left me-1"></i> กลับหน้าร้าน
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="py-5 my-auto">
        <div class="container">
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center text-muted small">
            <span>&copy; 2026 E-Commerce. สงวนลิขสิทธิ์ทุกประการ</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
