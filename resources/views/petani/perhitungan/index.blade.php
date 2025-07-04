@extends('adminlte::page')

@section('title', 'Perhitungan SPK')

@section('content_header')
    <h1>Perhitungan Rekomendasi Tanaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Masukkan Data Lingkungan Lahan Anda</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('perhitungan.hitung') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jenis_tanah">Jenis Tanah</label>
                            <select class="form-control" name="jenis_tanah" id="jenis_tanah">
                                <option value="Lempung">Lempung</option>
                                <option value="Berpasir">Berpasir</option>
                                <option value="Liat">Liat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="suhu">Suhu (°C)</label>
                            <input type="number" step="0.1" class="form-control" name="suhu" id="suhu" placeholder="Contoh: 28.5">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="curah_hujan">Curah Hujan (mm)</label>
                            <input type="number" class="form-control" name="curah_hujan" id="curah_hujan" placeholder="Contoh: 250">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ketersediaan_air">Ketersediaan Air</label>
                            <select class="form-control" name="ketersediaan_air" id="ketersediaan_air">
                                <option value="Banyak">Banyak</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Sedikit">Sedikit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelembaban">Kelembaban (%)</label>
                            <input type="number" class="form-control" name="kelembaban" id="kelembaban" placeholder="Contoh: 80">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Hitung Rekomendasi</button>
            </form>
        </div>
    </div>
@stop