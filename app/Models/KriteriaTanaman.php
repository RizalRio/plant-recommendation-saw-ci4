<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaTanaman extends Model
{
    use HasFactory;

    // Karena nama tabel Anda singular, kita tambahkan ini jika belum ada
    protected $table = 'kriteria_tanaman';

    /**
     * Mendefinisikan relasi bahwa satu KriteriaTanaman dimiliki oleh satu Tanaman.
     */
    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class, 'id_tanaman');
    }

    /**
     * Mendefinisikan relasi bahwa satu KriteriaTanaman dimiliki oleh satu Kriteria.
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
