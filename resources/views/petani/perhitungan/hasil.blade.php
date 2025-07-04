@extends('adminlte::page')

@section('title', 'Hasil Rekomendasi')

@section('content_header')
    <h1>Hasil Rekomendasi Tanaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Peringkat Tanaman Terbaik untuk Kondisi Lahan Anda</h3>
        </div>
        <div class="card-body">
            <p>Berdasarkan data input yang Anda berikan:</p>
            <ul>
                <li><strong>Jenis Tanah:</strong> {{ $inputPetani['jenis_tanah'] }}</li>
                <li><strong>Suhu:</strong> {{ $inputPetani['suhu'] }} °C</li>
                <li><strong>Curah Hujan:</strong> {{ $inputPetani['curah_hujan'] }} mm</li>
                <li><strong>Ketersediaan Air:</strong> {{ $inputPetani['ketersediaan_air'] }}</li>
                <li><strong>Kelembaban:</strong> {{ $inputPetani['kelembaban'] }} %</li>
            </ul>
            <hr>
            <h4>Hasil Peringkat:</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">Peringkat</th>
                        <th>Nama Tanaman</th>
                        <th>Skor Akhir (V)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilAkhir as $hasil)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hasil['nama_tanaman'] }}</td>
                            <td>{{ $hasil['skor'] }}</td>
                            <td>
                                @if($loop->first)
                                    <span class="badge bg-success">Sangat Direkomendasikan</span>
                                @else
                                    <span class="badge bg-info">Alternatif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary mt-3">Hitung Ulang</a>
        </div>
    </div>
@stop