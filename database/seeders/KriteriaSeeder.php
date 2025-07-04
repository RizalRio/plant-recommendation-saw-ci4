<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kriteria')->insert([
            ['nama_kriteria' => 'Jenis Tanah', 'bobot' => 0.2, 'tipe' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Suhu (°C)', 'bobot' => 0.25, 'tipe' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Curah Hujan (mm)', 'bobot' => 0.2, 'tipe' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Ketersediaan Air', 'bobot' => 0.2, 'tipe' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Kelembaban (%)', 'bobot' => 0.15, 'tipe' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
