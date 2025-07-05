@extends('adminlte::page')

@section('title', 'Manajemen Tanaman')

@section('content_header')
    <h1>Manajemen Tanaman</h1>
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
            <h3 class="card-title">Daftar Tanaman</h3>
            <div class="card-tools">
                <a href="{{ route('admin.tanaman.create') }}" class="btn btn-primary btn-sm">Tambah Tanaman</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama Tanaman</th>
                        <th>Jenis Tanah</th>
                        <th>Suhu</th>
                        <th>Curah Hujan</th>
                        <th>Ketersediaan Air</th>
                        <th>Kelembaban</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tanaman as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_tanaman }}</td>
                            <td>{{ $data->getKriteriaValue('Jenis Tanah') }}</td>
                            <td>{{ $data->getKriteriaValue('Suhu') }}</td>
                            <td>{{ $data->getKriteriaValue('Curah Hujan') }}</td>
                            <td>{{ $data->getKriteriaValue('Ketersediaan Air') }}</td>
                            <td>{{ $data->getKriteriaValue('Kelembaban') }}</td>
                            <td>
                                <form action="{{ route('admin.tanaman.destroy', $data->id) }}" method="POST">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.tanaman.edit', $data->id) }}"
                                        class="btn btn-xs btn-warning">Edit</a>

                                    @csrf
                                    @method('DELETE') {{-- Method spoofing untuk request DELETE --}}

                                    {{-- Tombol Hapus dengan konfirmasi JavaScript --}}
                                    <button type="submit" class="btn btn-xs btn-danger"
                                        onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data tidak ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
