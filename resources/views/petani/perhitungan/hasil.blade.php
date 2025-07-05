@extends('adminlte::page')

@section('title', 'Hasil Rekomendasi')

@section('content_header')
    <h1>Hasil Rekomendasi Tanaman</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kondisi Lahan (Input Pengguna)</h3>
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Alternatif</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Tanaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alternatifs as $alternatif)
                                <tr>
                                    <td>A{{ $loop->iteration }}</td>
                                    <td>{{ $alternatif->nama_tanaman }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Bobot Kriteria</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriterias as $kriteria)
                                <tr>
                                    <td>C{{ $loop->iteration }}</td>
                                    <td>{{ $kriteria->nama_kriteria }}</td>
                                    <td>{{ $kriteria->bobot }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Matriks Keputusan (Nilai Kecocokan Kriteria)</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm text-center">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriterias as $kriteria)
                            <th>C{{ $loop->iteration }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatifs as $alternatif)
                        <tr>
                            <td><b>{{ $alternatif->nama_tanaman }}</b></td>
                            @foreach ($kriterias as $kriteria)
                                <td>
                                    @php
                                        // Cari nilai preferensi yang sesuai
                                        $nilaiPreferensi = $alternatif->kriteriaTanaman->firstWhere('id_kriteria', $kriteria->id);
                                    @endphp
                                    {{ $nilaiPreferensi->nilai ?? '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Matriks Ternormalisasi (R)</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm text-center">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriterias as $kriteria)
                            <th>C{{ $loop->iteration }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatifs as $alternatif)
                        <tr>
                            <td><b>{{ $alternatif->nama_tanaman }}</b></td>
                            @foreach ($kriterias as $kriteria)
                                <td>
                                    {{ round($normalizedMatrix[$alternatif->id][$kriteria->id], 4) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hasil Akhir Perankingan</h3>
        </div>
        <div class="card-body">
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
                            <td><b>{{ $hasil['skor'] }}</b></td>
                            <td>
                                @if ($loop->first)
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