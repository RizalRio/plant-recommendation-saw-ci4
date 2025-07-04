<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
