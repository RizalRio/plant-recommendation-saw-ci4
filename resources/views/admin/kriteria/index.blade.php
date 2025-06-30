@extends('adminlte::page')

@section('title', 'Manajemen Kriteria')

@section('content_header')
    <h1>Manajemen Kriteria</h1>
@stop

@section('content')
    {{-- Menampilkan pesan sukses --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kriteria</h3>
            <div class="card-tools">
                <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Tipe</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriteria as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_kriteria }}</td>
                            <td>{{ $data->bobot }}</td>
                            <td>{{ $data->tipe }}</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-warning">Edit</a>
                                <a href="#" class="btn btn-xs btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop