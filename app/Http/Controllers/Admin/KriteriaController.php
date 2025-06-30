<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data dari tabel 'kriterias'
        $kriteria = Kriteria::all();

        // 2. Tampilkan halaman view dan kirim data $kriteria ke sana
        return view('admin.kriteria.index', compact('kriteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'tipe' => 'required|in:benefit,cost',
        ]);

        // 2. Jika validasi berhasil, simpan data ke database
        // menggunakan metode Mass Assignment yang sudah kita izinkan di Model
        Kriteria::create($request->all());

        // 3. Alihkan (redirect) pengguna kembali ke halaman daftar kriteria
        // sambil mengirimkan pesan sukses
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria) {}

    /**
     * Show the form for editing the specified resource.
     */
    // FUNGSI EDIT YANG BARU (BENAR)
    public function edit(Kriteria $kriterium)
    {
        // Kirim ke view dengan nama 'kriteria' agar view lama tetap berfungsi
        return view('admin.kriteria.edit', ['kriteria' => $kriterium]);
    }

    // FUNGSI UPDATE YANG BARU (BENAR)
    public function update(Request $request, Kriteria $kriterium)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            // Rule 'unique' diubah agar mengabaikan data yang sedang diedit
            'nama_kriteria' => 'required|string|max:255|unique:kriteria,nama_kriteria,' . $kriterium->id,
            'bobot' => 'required|numeric|min:0|max:1',
            'tipe' => 'required|in:benefit,cost',
        ]);

        // 2. Jika validasi berhasil, update data di database
        $kriterium->update($request->all());

        // 3. Redirect ke halaman index kriteria dengan pesan sukses
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriterium)
    {
        // Hapus data dari database berdasarkan model yang sudah ditemukan otomatis
        $kriterium->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil dihapus.');
    }
}
