<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tanaman')->insert([
            ['nama_tanaman' => 'Padi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_tanaman' => 'Jagung', 'created_at' => now(), 'updated_at' => now()],
            ['nama_tanaman' => 'Kedelai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
