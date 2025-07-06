<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanaman;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;

class TanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tanaman = Tanaman::latest()->with('kriteria')->get();
        return view('admin.tanaman.index', compact('tanaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriteria = Kriteria::all();
        return view('admin.tanaman.create', compact('kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tanaman' => 'required|string|max:255|unique:tanaman,nama_tanaman',
            'kriteria' => 'required|array',
            'kriteria.*' => 'required|string', // Validasi setiap nilai kriteria
        ]);

        try {
            DB::beginTransaction();
            $tanaman = Tanaman::create(['nama_tanaman' => $request->nama_tanaman]);

            $kriteriaToSync = [];
            foreach ($request->kriteria as $kriteriaId => $value) {
                // Ubah key di sini dari 'value' menjadi 'nilai'
                $kriteriaToSync[$kriteriaId] = ['nilai' => $value];
            }

            $tanaman->kriteria()->sync($kriteriaToSync);
            DB::commit();

            return redirect()->route('admin.tanaman.index')->with('success', 'Data tanaman berhasil ditambahkan.');
            // } catch (\Exception $e) {
            //     DB::rollBack();
            //     // Optional: Log the error
            //     // Log::error($e->getMessage());
            //     return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
            // }
        } catch (\Exception $e) {
            DB::rollBack();

            // =======================================================
            // == UBAH BAGIAN CATCH INI UNTUK DEBUGGING ==
            // =======================================================
            // Hentikan eksekusi dan tampilkan pesan error yang sebenarnya
            dd($e->getMessage());
            // =======================================================

            // return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
        }
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
    public function edit(Tanaman $tanaman) // Gunakan Route Model Binding
    {
        // Load relasi kriteria untuk tanaman yang akan diedit
        $tanaman->load('kriteria');

        // Ambil semua kriteria untuk membangun form
        $kriteria = Kriteria::all();

        return view('admin.tanaman.edit', compact('tanaman', 'kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanaman $tanaman) // Gunakan Route Model Binding
    {
        $request->validate([
            'nama_tanaman' => 'required|string|max:255|unique:tanaman,nama_tanaman,' . $tanaman->id,
            'kriteria' => 'required|array',
            'kriteria.*' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $tanaman->update(['nama_tanaman' => $request->nama_tanaman]);

            $kriteriaToSync = [];
            foreach ($request->kriteria as $kriteriaId => $value) {
                // Ubah key di sini juga dari 'value' menjadi 'nilai'
                $kriteriaToSync[$kriteriaId] = ['nilai' => $value];
            }

            $tanaman->kriteria()->sync($kriteriaToSync);
            DB::commit();

            return redirect()->route('admin.tanaman.index')->with('success', 'Data tanaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanaman $tanaman) // Gunakan Route Model Binding
    {
        // 1. Lepaskan semua relasi Many-to-Many dengan kriteria terlebih dahulu.
        // Ini akan menghapus entri terkait di tabel pivot (kriteria_tanaman).
        // Ini penting jika foreign key di tabel pivot tidak memiliki ON DELETE CASCADE.
        $tanaman->kriteria()->detach();

        // 2. Sekarang, hapus data tanaman itu sendiri.
        // Setelah entri di tabel pivot dihapus, data tanaman (parent) dapat dihapus.
        $tanaman->delete();

        // 3. Redirect kembali dengan pesan sukses.
        return redirect()->route('admin.tanaman.index')
            ->with('success', 'Data tanaman dan kriteria terkait berhasil dihapus.');
    }
}
