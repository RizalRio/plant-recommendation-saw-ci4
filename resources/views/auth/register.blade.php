@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', 'Buat Akun Baru')

@section('auth_body')
    <form action="{{ route('register') }}" method="post">
        @csrf

        {{-- Input Nama Lengkap --}}
        <div class="input-group mb-3">
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama') }}" placeholder="Nama Lengkap" autofocus>
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
            @error('nama') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        {{-- Input Username --}}
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username') }}" placeholder="Username">
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user-tag"></span></div></div>
            @error('username') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        {{-- Input Peran --}}
        <div class="input-group mb-3">
            <select name="peran" class="form-control @error('peran') is-invalid @enderror">
                <option value="" disabled selected>-- Pilih Peran --</option>
                <option value="Admin" {{ old('peran') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Petani" {{ old('peran') == 'Petani' ? 'selected' : '' }}>Petani</option>
            </select>
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-users-cog"></span></div></div>
            @error('peran') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        {{-- Input Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password">
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        {{-- Input Konfirmasi Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Ketik Ulang Password">
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>

        {{-- Tombol Register --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Daftar
        </button>
    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            Saya sudah punya akun
        </a>
    </p>
@stop