<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\Tanaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data untuk small box (Statistik)
        $userCount = User::count();
        $criteriaCount = Kriteria::count();
        $plantCount = Tanaman::count();

        // Dapatkan user yang sedang login
        $user = Auth::user();

        // 1. Ambil SEMUA nama tanaman sebagai dasar untuk label grafik.
        $semuaNamaTanaman = Tanaman::orderBy('nama_tanaman')->pluck('nama_tanaman');

        // 2. Jalankan query untuk menghitung data rekomendasi yang sudah ada.
        $subQuery = DB::table('rekomendasi')
            ->select('id_data', DB::raw('MAX(skor) as max_skor'))
            ->groupBy('id_data');

        $queryUtama = DB::table('rekomendasi as r')
            ->joinSub($subQuery, 'max_scores', function ($join) {
                $join->on('r.id_data', '=', 'max_scores.id_data')
                    ->on('r.skor', '=', 'max_scores.max_skor');
            })
            ->join('tanaman as t', 'r.id_tanaman', '=', 't.id')
            ->when($user->peran === 'Petani', function ($query) use ($user) {
                return $query->join('data_lingkungan as dl', 'r.id_data', '=', 'dl.id')
                    ->where('dl.id_user', 'like', $user->id);
            });

        // Ubah hasil query agar nama tanaman menjadi 'key' untuk pencarian mudah.
        $hasilRekomendasi = $queryUtama->select('t.nama_tanaman', DB::raw('COUNT(t.id) as total'))
            ->groupBy('t.nama_tanaman')
            ->get()
            ->keyBy('nama_tanaman'); // ->keyBy() adalah kuncinya

        // 3. Siapkan data akhir untuk grafik.
        // Loop melalui semua nama tanaman, cek nilainya di hasil rekomendasi,
        // jika tidak ada, beri nilai 0.
        $chartData = $semuaNamaTanaman->map(function ($namaTanaman) use ($hasilRekomendasi) {
            return $hasilRekomendasi[$namaTanaman]->total ?? 0;
        });

        // =================================================================

        // Kirim data ke view
        return view('admin.dashboard.index', [
            'userCount' => $userCount,
            'criteriaCount' => $criteriaCount,
            'plantCount' => $plantCount,
            'chartLabels' => $semuaNamaTanaman, // Gunakan semua nama tanaman untuk label
            'chartData' => $chartData,         // Gunakan data yang sudah diproses untuk nilai
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
