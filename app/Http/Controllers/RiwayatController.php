<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataLingkungan;
use App\Models\Kriteria;
use App\Models\Tanaman;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua data lingkungan milik user yang sedang login,
        // urutkan dari yang terbaru, dan ambil juga data relasi rekomendasinya.
        $riwayat = \App\Models\DataLingkungan::where('id_user', Auth::id())
            ->with('rekomendasi.tanaman')
            ->latest()
            ->get();

        return view('petani.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        // 1. Ambil data riwayat spesifik berdasarkan ID
        $dataLingkungan = DataLingkungan::findOrFail($id);

        // Pastikan user hanya bisa melihat riwayat miliknya sendiri
        if ($dataLingkungan->id_user !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Ambil kembali input petani dari data riwayat
        $inputPetani = [
            'jenis_tanah' => $dataLingkungan->jenis_tanah,
            'suhu' => $dataLingkungan->suhu,
            'curah_hujan' => $dataLingkungan->curah_hujan,
            'ketersediaan_air' => $dataLingkungan->ketersediaan_air,
            'kelembaban' => $dataLingkungan->kelembaban,
        ];

        // 2. Ambil semua data yang dibutuhkan untuk perhitungan (sama seperti di PerhitunganController)
        $alternatifs = Tanaman::with('kriteriaTanaman.kriteria')->get();
        $kriterias = Kriteria::all();

        // 3. Lakukan kembali proses normalisasi (tanpa menyimpan data baru)
        $normalizedMatrix = [];
        $calculateNormalizationFn = function ($preferensi, $input, $namaKriteria) {
            if (in_array($namaKriteria, ['Jenis Tanah', 'Ketersediaan Air'])) {
                return strtolower(trim($preferensi)) == strtolower(trim($input)) ? 1 : 0;
            }
            if (strpos($preferensi, '-') !== false) {
                list($min, $max) = explode('-', $preferensi);
                $ideal = (floatval($max) + floatval($min)) / 2;
                $halfRange = (floatval($max) - floatval($min)) / 2;
                if ($halfRange == 0) return floatval($input) == $ideal ? 1 : 0;
                $jarak = abs(floatval($input) - $ideal);
                if ($jarak > $halfRange) return 0;
                return 1 - ($jarak / $halfRange);
            }
            return 0;
        };

        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $preferensi = $alternatif->kriteriaTanaman->firstWhere('id_kriteria', $kriteria->id);
                if ($preferensi) {
                    $inputKey = strtolower(str_replace([' (°C)', ' (mm)', ' (%)'], '', $kriteria->nama_kriteria));
                    $inputKey = str_replace(' ', '_', $inputKey);
                    $input = $inputPetani[$inputKey];
                    $nilai_r = $calculateNormalizationFn($preferensi->nilai, $input, $kriteria->nama_kriteria);
                    $normalizedMatrix[$alternatif->id][$kriteria->id] = $nilai_r;
                } else {
                    $normalizedMatrix[$alternatif->id][$kriteria->id] = 0;
                }
            }
        }

        // 4. Lakukan kembali proses perankingan (tanpa menyimpan data baru)
        $hasilAkhir = [];
        foreach ($alternatifs as $alternatif) {
            $totalSkor = 0;
            foreach ($kriterias as $kriteria) {
                $skorNormal = $normalizedMatrix[$alternatif->id][$kriteria->id];
                $totalSkor += $skorNormal * $kriteria->bobot;
            }
            $hasilAkhir[] = [
                'nama_tanaman' => $alternatif->nama_tanaman,
                'skor' => round($totalSkor, 4),
            ];
        }

        usort($hasilAkhir, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        // 5. Kirim semua hasil perhitungan ke view yang sama dengan halaman hasil
        return view('petani.perhitungan.hasil', compact(
            'hasilAkhir',
            'inputPetani',
            'alternatifs',
            'kriterias',
            'normalizedMatrix'
        ));
    }
}
