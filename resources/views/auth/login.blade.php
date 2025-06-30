{{-- Menggunakan layout khusus untuk halaman autentikasi, bukan layout dashboard --}}
@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

{{-- Mengganti header default dari "Sign in to start your session" --}}
@section('auth_header', 'Selamat Datang! Silakan Login')

{{-- Bagian body dari form login --}}
@section('auth_body')
    <form action="{{ route('login') }}" method="post">
        @csrf

        {{-- Input Username --}}
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username') }}" placeholder="Username" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Input Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Baris untuk Tombol Login dan Remember Me --}}
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary" title="Ingat saya untuk sesi berikutnya">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    Login
                </button>
            </div>
        </div>

    </form>
@stop

{{-- Bagian footer di bawah kotak login --}}
@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('register') }}">
            Saya belum punya akun, daftar sekarang
        </a>
    </p>
@stop