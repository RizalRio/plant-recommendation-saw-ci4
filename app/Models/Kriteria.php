<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    /**
     * Memberitahu Laravel bahwa nama tabel untuk model ini adalah 'kriteria' (singular).
     *
     * @var string
     */
    protected $table = 'kriteria';

    protected $fillable = [
        'nama_kriteria',
        'bobot',
        'tipe',
    ];
}
