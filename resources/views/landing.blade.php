<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Rekomendasi Tanaman</title>

    {{-- Menggunakan CSS dari AdminLTE yang sudah kita install --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('landing') }}" class="navbar-brand">
                <i class="fas fa-leaf mr-2"></i>
                <span class="brand-text font-weight-light">SPK Tanaman</span>
            </a>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            </div>

            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="row justify-content-center text-center pt-5">
                    <div class="col-lg-8">
                        <h1 class="display-4 font-weight-bold">Optimalkan Hasil Panen Anda</h1>
                        <p class="lead mt-3">
                            Produktivitas petani sering terhambat karena ketidakpastian dalam memilih jenis tanaman yang sesuai.  Sistem kami membantu Anda mengambil keputusan berbasis data untuk hasil yang lebih maksimal.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-seedling mr-2"></i>
                                Mulai Sekarang, Gratis!
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                                Masuk ke Akun Anda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container">
            <div class="float-right d-none d-sm-inline">
            Sistem Penunjang Keputusan
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">Tim Anda</a>.</strong> All rights reserved.
        </div>
    </footer>
</div>
{{-- Menggunakan JS dari AdminLTE --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>