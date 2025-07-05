<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerhitunganController extends Controller
{
    // Fungsi ini untuk menampilkan halaman form perhitungan
    public function index()
    {
        return view('petani.perhitungan.index');
    }

    public function hitung(Request $request): View
    {
        // 1. Validasi (Tidak berubah)
        $inputPetani = $request->validate([
            'jenis_tanah' => 'required|string',
            'suhu' => 'required|numeric',
            'curah_hujan' => 'required|numeric',
            'ketersediaan_air' => 'required|string',
            'kelembaban' => 'required|numeric',
        ]);

        // === BAGIAN BARU 1: Simpan Input Petani ke DB ===
        $dataLingkungan = \App\Models\DataLingkungan::create([
            'id_user' => auth()->id(), // Ambil ID user yang sedang login
            'jenis_tanah' => $inputPetani['jenis_tanah'],
            'suhu' => $inputPetani['suhu'],
            'curah_hujan' => $inputPetani['curah_hujan'],
            'ketersediaan_air' => $inputPetani['ketersediaan_air'],
            'kelembaban' => $inputPetani['kelembaban'],
        ]);
        // ==============================================

        // 2. Ambil semua data yang dibutuhkan (Tidak berubah)
        $alternatifs = Tanaman::with('kriteriaTanaman.kriteria')->get();
        $kriterias = Kriteria::all();

        // 3. Proses Normalisasi (Tidak berubah)
        // ... (Kode normalisasi dari langkah sebelumnya tetap di sini) ...
        $normalizedMatrix = [];
        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $preferensi = $alternatif->kriteriaTanaman->firstWhere('id_kriteria', $kriteria->id);
                if ($preferensi) {
                    $inputKey = strtolower(str_replace([' (°C)', ' (mm)', ' (%)'], '', $kriteria->nama_kriteria));
                    $inputKey = str_replace(' ', '_', $inputKey);
                    $input = $inputPetani[$inputKey];
                    $nilai_r = $this->calculateNormalization($preferensi->nilai, $input, $kriteria->nama_kriteria);
                    $normalizedMatrix[$alternatif->id][$kriteria->id] = $nilai_r;
                } else {
                    $normalizedMatrix[$alternatif->id][$kriteria->id] = 0;
                }
            }
        }

        // 4. Proses Perankingan (Tidak berubah)
        // ... (Kode perankingan dari langkah sebelumnya tetap di sini) ...
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

        // 5. Urutkan hasil (Tidak berubah)
        usort($hasilAkhir, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        // === BAGIAN BARU 2: Simpan Hasil Rekomendasi ke DB ===
        foreach ($hasilAkhir as $hasil) {
            // Cari id_tanaman berdasarkan nama untuk disimpan
            $tanaman = Tanaman::where('nama_tanaman', $hasil['nama_tanaman'])->first();

            if ($tanaman) {
                \App\Models\Rekomendasi::create([
                    'id_data' => $dataLingkungan->id, // Hubungkan ke input yang baru disimpan
                    'id_tanaman' => $tanaman->id,
                    'skor' => $hasil['skor'],
                ]);
            }
        }
        // ==============================================

        // 6. Kirim hasil ke view (Tidak berubah)
        //return view('petani.perhitungan.hasil', compact('hasilAkhir', 'inputPetani'));

        // Menjadi seperti ini:
        return view('petani.perhitungan.hasil', compact(
            'hasilAkhir',
            'inputPetani',
            'alternatifs',      // Data semua tanaman
            'kriterias',        // Data semua kriteria
            'normalizedMatrix'  // Matriks hasil normalisasi
        ));
    }

    private function calculateNormalization($preferensi, $input, $namaKriteria)
    {
        // Handle kriteria kategorikal (Jenis Tanah, Ketersediaan Air)
        if (in_array($namaKriteria, ['Jenis Tanah', 'Ketersediaan Air'])) {
            return strtolower(trim($preferensi)) == strtolower(trim($input)) ? 1 : 0;
        }

        // Handle kriteria numerik (Suhu, Curah Hujan, Kelembaban)
        if (strpos($preferensi, '-') !== false) {
            list($min, $max) = explode('-', $preferensi);

            // Rumus dari dokumen SPK Anda
            $ideal = (floatval($max) + floatval($min)) / 2;
            $halfRange = (floatval($max) - floatval($min)) / 2;

            if ($halfRange == 0) {
                return floatval($input) == $ideal ? 1 : 0;
            }

            $jarak = abs(floatval($input) - $ideal);

            if ($jarak > $halfRange) {
                return 0; // Di luar jangkauan, skor 0
            }

            return 1 - ($jarak / $halfRange);
        }

        // Jika format tidak dikenali, kembalikan 0
        return 0;
    }
}
