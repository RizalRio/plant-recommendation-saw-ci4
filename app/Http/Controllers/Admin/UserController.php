<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();

        // Kirim data ke view
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'peran' => 'required|string|in:Admin,Petani',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // 2. Buat user baru menggunakan Hash untuk password
        \App\Models\User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'peran' => $request->peran,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Route Model Binding bekerja sempurna di sini karena
        // parameter rute {user} cocok dengan variabel $user.
        // Kita langsung kirim data user yang ditemukan ke view.
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Aturan Validasi
        $rules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'peran' => 'string|in:Admin,Petani', // Tidak 'required' karena bisa di-disable
        ];

        // Jika password diisi, tambahkan aturan validasi untuk password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|confirmed|min:8';
        }

        $request->validate($rules);

        // 2. Siapkan data untuk diupdate
        $dataToUpdate = [
            'nama' => $request->nama,
            'username' => $request->username,
        ];

        // 3. Cek jika admin mengubah peran (dan itu bukan dirinya sendiri)
        if ($request->filled('peran') && auth()->user()->id != $user->id) {
            $dataToUpdate['peran'] = $request->peran;
        }

        // 4. Cek jika ada password baru yang diinput
        if ($request->filled('password')) {
            $dataToUpdate['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        // 5. Update data di database
        $user->update($dataToUpdate);

        // 6. Redirect dengan pesan sukses
        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // 1. Lapisan keamanan tambahan di backend
        // Mencegah admin menghapus akunnya sendiri secara paksa (misal via tool lain)
        if (auth()->user()->id == $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // 2. Hapus data dari database
        $user->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil dihapus.');
    }
}
