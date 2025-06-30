@extends('adminlte::page')

@section('title', 'Edit Kriteria')

{{-- Judul Halaman, diubah menjadi 'Edit' --}}
@section('content_header')
    <h1>Edit Kriteria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Kriteria</h3>
        </div>
        <div class="card-body">
            {{-- Form diubah agar mengarah ke route 'update' dan membawa ID kriteria --}}
            <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Ini adalah method khusus untuk memberitahu Laravel bahwa ini proses UPDATE --}}

                <div class="form-group">
                    <label for="nama_kriteria">Nama Kriteria</label>
                    {{-- 'value' diisi dengan data lama. 'old()' digunakan agar jika ada error validasi, inputan terakhir tidak hilang --}}
                    <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                           id="nama_kriteria" name="nama_kriteria" 
                           value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" 
                           placeholder="Masukkan nama kriteria">
                    
                    {{-- Menampilkan pesan error validasi untuk field ini --}}
                    @error('nama_kriteria')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bobot">Bobot</label>
                    {{-- 'value' diisi dengan data lama --}}
                    <input type="text" class="form-control @error('bobot') is-invalid @enderror" 
                           id="bobot" name="bobot" 
                           value="{{ old('bobot', $kriteria->bobot) }}" 
                           placeholder="Contoh: 0.25">

                    {{-- Menampilkan pesan error validasi untuk field ini --}}
                    @error('bobot')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tipe">Tipe Kriteria</label>
                    <select class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe">
                        {{-- Logika untuk memilih opsi 'benefit' atau 'cost' berdasarkan data lama --}}
                        <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>

                    {{-- Menampilkan pesan error validasi untuk field ini --}}
                    @error('tipe')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@stop