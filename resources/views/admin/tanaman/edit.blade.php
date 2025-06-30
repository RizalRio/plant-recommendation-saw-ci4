@extends('adminlte::page')

@section('title', 'Edit Tanaman')

@section('content_header')
    <h1>Edit Tanaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data: {{ $tanaman->nama_tanaman }}</h3>
        </div>
        <div class="card-body">
            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tanaman.update', $tanaman->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

                {{-- Input untuk Nama Tanaman --}}
                <div class="form-group">
                    <label for="nama_tanaman">Nama Tanaman</label>
                    {{-- 
                        old('nama_tanaman', $tanaman->nama_tanaman)
                        Artinya: Gunakan input lama 'nama_tanaman' jika ada, jika tidak, gunakan nilai dari database.
                    --}}
                    <input type="text" class="form-control" id="nama_tanaman" name="nama_tanaman"
                        value="{{ old('nama_tanaman', $tanaman->nama_tanaman) }}" required>
                </div>

                <hr>
                <h5 class="mb-3">Nilai Kriteria</h5>

                {{-- Loop untuk membuat input kriteria secara dinamis --}}
                @foreach ($kriteria as $item)
                    <div class="form-group">
                        <label for="kriteria_{{ $item->id }}">{{ $item->nama_kriteria }}</label>

                        {{-- 
                            Logika value di sini sangat penting.
                            1. old('kriteria.'.$item->id): Cek dulu apakah ada input lama untuk kriteria ini (jika validasi gagal).
                            2. $tanaman->getKriteriaValue($item->nama_kriteria): Jika tidak ada input lama, tampilkan nilai yang sudah ada dari database.
                        --}}
                        <input type="text" class="form-control" id="kriteria_{{ $item->id }}"
                            name="kriteria[{{ $item->id }}]"
                            value="{{ old('kriteria.' . $item->id, $tanaman->getKriteriaValue($item->nama_kriteria)) }}"
                            required>
                    </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('admin.tanaman.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@stop
