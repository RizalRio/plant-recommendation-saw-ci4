@extends('adminlte::page')

@section('title', 'Tambah Kriteria')

@section('content_header')
    <h1>Tambah Kriteria</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Data</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kriteria.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_kriteria">Nama Kriteria</label>
                    <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" placeholder="Masukkan nama kriteria">
                </div>

                <div class="form-group">
                    <label for="bobot">Bobot</label>
                    <input type="text" class="form-control" id="bobot" name="bobot" placeholder="Contoh: 0.25">
                </div>

                <div class="form-group">
                    <label for="tipe">Tipe Kriteria</label>
                    <select class="form-control" id="tipe" name="tipe">
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                </div>

                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop