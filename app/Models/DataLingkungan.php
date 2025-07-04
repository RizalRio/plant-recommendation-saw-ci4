<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLingkungan extends Model
{
    use HasFactory;
    protected $table = 'data_lingkungan'; // Sesuaikan jika nama tabel Anda berbeda

    protected $fillable = [
        'id_user',
        'jenis_tanah',
        'suhu',
        'curah_hujan',
        'ketersediaan_air',
        'kelembaban',
    ];

    // di dalam class DataLingkungan
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }

    public function rekomendasi()
    {
        return $this->hasMany(\App\Models\Rekomendasi::class, 'id_data')->orderBy('skor', 'desc');
    }
}
