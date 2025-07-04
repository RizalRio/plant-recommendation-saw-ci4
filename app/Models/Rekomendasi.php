<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;
    protected $table = 'rekomendasi'; // Sesuaikan jika nama tabel Anda berbeda

    protected $fillable = [
        'id_data',
        'id_tanaman',
        'skor',
    ];

    // di dalam class Rekomendasi
    public function tanaman()
    {
        return $this->belongsTo(\App\Models\Tanaman::class, 'id_tanaman');
    }
}
