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
            'use strict'

            // Dapatkan context dari canvas
            var ctx = document.getElementById('rekomendasiChart').getContext('2d');

            // Data untuk chart, disesuaikan dengan gambar
            var data = {
                labels: ['Padi', 'Jagung', 'Kedelai'],
                datasets: [{
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: [6, 7.5, 4] // Perkiraan nilai dari gambar
                }]
            }

            var options = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false // Sembunyikan legend
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false, // Sembunyikan grid garis vertikal
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 20, // Atur skala maksimal
                            stepSize: 5 // Atur interval skala
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
