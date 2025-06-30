@extends('adminlte::page')

@section('title', 'Tambah Tanaman')

@section('content_header')
    <h1>Tambah Tanaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Data</h3>
        </div>
        <div class="card-body">
            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tanaman.store') }}" method="POST">
                @csrf
                {{-- Input untuk Nama Tanaman --}}
                <div class="form-group">
                    <label for="nama_tanaman">Nama Tanaman</label>
                    <input type="text" class="form-control" id="nama_tanaman" name="nama_tanaman"
                        placeholder="Masukkan nama tanaman" value="{{ old('nama_tanaman') }}" required>
                </div>

                <hr>
                <h5 class="mb-3">Nilai Kriteria</h5>

                {{-- Loop untuk membuat input kriteria secara dinamis --}}
                @foreach ($kriteria as $item)
                    <div class="form-group">
                        <label for="kriteria_{{ $item->id }}">{{ $item->nama_kriteria }}</label>

                        {{-- Nama input dibuat menjadi array: name="kriteria[id_kriteria]" --}}
                        <input type="text" class="form-control" id="kriteria_{{ $item->id }}"
                            name="kriteria[{{ $item->id }}]"
                            placeholder="Masukkan nilai untuk {{ $item->nama_kriteria }}"
                            value="{{ old('kriteria.' . $item->id) }}" {{-- Mempertahankan nilai lama jika validasi gagal --}} required>
                    </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@stop
