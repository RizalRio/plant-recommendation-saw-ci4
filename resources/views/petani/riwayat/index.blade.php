@extends('adminlte::page')

@section('title', 'Riwayat Perhitungan')

@section('content_header')
    <h1>Riwayat Perhitungan SPK</h1>
@stop

@section('content')
    @forelse ($riwayat as $item)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Perhitungan pada: {{ $item->created_at->format('d F Y, H:i') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Input Anda:</h5>
                        <ul>
                            <li><strong>Jenis Tanah:</strong> {{ $item->jenis_tanah }}</li>
                            <li><strong>Suhu:</strong> {{ $item->suhu }} °C</li>
                            <li><strong>Curah Hujan:</strong> {{ $item->curah_hujan }} mm</li>
                            <li><strong>Ketersediaan Air:</strong> {{ $item->ketersediaan_air }}</li>
                            <li><strong>Kelembaban:</strong> {{ $item->kelembaban }} %</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Hasil Rekomendasi Utama:</h5>
                        @if ($item->rekomendasi->isNotEmpty())
                            <div class="text-center">
                                <h2 class="text-success">{{ $item->rekomendasi->first()->tanaman->nama_tanaman }}</h2>
                                <p>Dengan Skor: {{ $item->rekomendasi->first()->skor }}</p>
                            </div>
                        @else
                            <p>Tidak ada hasil rekomendasi untuk perhitungan ini.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- TAMBAHKAN BAGIAN INI --}}
            <div class="card-footer text-right">
                <a href="{{ route('riwayat.show', $item->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Lihat Detail Perhitungan
                </a>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body">
                <p class="text-center">Anda belum memiliki riwayat perhitungan.</p>
                <div class="text-center">
                    <a href="{{ route('perhitungan.index') }}" class="btn btn-primary">Mulai Perhitungan Baru</a>
                </div>
            </div>
        </div>
    @endforelse
@stop