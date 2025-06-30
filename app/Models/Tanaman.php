<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tanaman extends Model
{
    use HasFactory;
    protected $table = 'tanaman';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tanaman',
    ];


    /**
     * Mendefinisikan relasi many-to-many ke Kriteria.
     * Laravel akan menggunakan tabel pivot 'kriteria_tanaman'.
     * withPivot('value') sangat penting untuk mengambil kolom 'value' dari tabel pivot.
     */
    public function kriteria()
    {
        return $this->belongsToMany(
            Kriteria::class,
            'kriteria_tanaman',
            'id_tanaman',
            'id_kriteria'
        )->withPivot('nilai');
    }

    public function getKriteriaValue(string $namaKriteria): string
    {
        $kriteria = $this->kriteria->firstWhere('nama_kriteria', $namaKriteria);
        return $kriteria ? $kriteria->pivot->nilai : 'N/A';
    }
}
