@extends('adminlte::page')

@section('title', 'Edit Pengguna')

@section('content_header')
    <h1>Edit Pengguna</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Pengguna</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $user->nama) }}">
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}">
                    @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="peran">Peran</label>
                    {{-- Tambahkan 'disabled' jika admin mengedit profilnya sendiri --}}
                    <select class="form-control @error('peran') is-invalid @enderror" id="peran" name="peran" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>
                        <option value="Admin" {{ old('peran', $user->peran) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Petani" {{ old('peran', $user->peran) == 'Petani' ? 'selected' : '' }}>Petani</option>
                    </select>
                    {{-- Beri pesan bantuan jika dropdown di-disable --}}
                    @if(Auth::user()->id == $user->id)
                        <small class="form-text text-muted">Anda tidak dapat mengubah peran akun Anda sendiri.</small>
                    @endif
                    @error('peran') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@stop