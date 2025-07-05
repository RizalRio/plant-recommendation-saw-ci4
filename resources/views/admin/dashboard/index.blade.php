@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            {{-- Menampilkan variabel yang dikirim dari controller --}}
                            <h3>{{ $userCount }}</h3>
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-plus"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $criteriaCount }}</h3>
                            <p>Kriteria</p>
                        </div>
                        <div class="icon"><i class="fas fa-list"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $plantCount }}</h3>
                            <p>Tanaman</p>
                        </div>
                        <div class="icon"><i class="fas fa-seedling"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- BARIS BARU UNTUK GRAFIK -->
            <div class="row">
                <section class="col-lg-12">
                    <!-- Card untuk Grafik -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Grafik Rekomendasi
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:300px; width:100%;">
                                <canvas id="rekomendasiChart"></canvas>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>
    <!-- /.content -->
@stop

{{-- Section baru untuk menempatkan script JS --}}
@section('js')
    <script>
        $(function() {
            'use strict';

            // 1. Definisikan palet warna yang akan digunakan untuk bar dan border
            const colorPalette = [
                'rgba(255, 99, 132, 0.5)',  // Merah
                'rgba(54, 162, 235, 0.5)', // Biru
                'rgba(255, 206, 86, 0.5)',  // Kuning
                'rgba(75, 192, 192, 0.5)',  // Hijau
                'rgba(153, 102, 255, 0.5)',// Ungu
                'rgba(255, 159, 64, 0.5)'  // Oranye
            ];

            const borderPalette = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];

            // 2. Ambil data dari controller
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            // 3. Buat array warna untuk setiap bar berdasarkan jumlah label
            //    Warna akan berulang jika jumlah label lebih banyak dari palet warna
            const backgroundColors = chartLabels.map((_, index) => colorPalette[index % colorPalette.length]);
            const borderColors = chartLabels.map((_, index) => borderPalette[index % borderPalette.length]);

            // =================================================================

            // Dapatkan context dari canvas
            var ctx = document.getElementById('rekomendasiChart').getContext('2d');

            // Data untuk chart
            var data = {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Rekomendasi',
                    backgroundColor: backgroundColors, // Gunakan array warna
                    borderColor: borderColors,     // Gunakan array warna
                    borderWidth: 1,                // Tambahkan ketebalan border
                    data: chartData
                }]
            }

            // Opsi untuk chart
            var options = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    }]
                }
            }

            // Inisialisasi Chart baru
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    </script>
@stop
