<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // Fungsi ini untuk MENAMPILKAN halaman/form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Fungsi ini untuk MEMPROSES data dari form login
    public function loginProcess(Request $request): RedirectResponse
    {
        // 1. Validasi Inputan
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Proses Autentikasi (di sinilah 'sihir' Laravel bekerja)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil...
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // 3. Jika Gagal...
        return back()->withErrors([
            'username' => 'Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function registerProcess(Request $request): RedirectResponse
    {
        // 1. Validasi semua inputan
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'peran' => ['required', 'string', 'in:Admin,Petani'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        // 2. Buat user baru di database
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'peran' => $request->peran,
            'password' => Hash::make($request->password), // Password di-hash (diamankan)
        ]);

        // 3. (Opsional) Kirim event bahwa user baru terdaftar
        event(new Registered($user));

        // 4. Langsung login-kan user yang baru mendaftar
        Auth::login($user);

        // 5. Arahkan ke halaman dashboard
        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // 'Perintah' untuk menghapus sesi login pengguna

        $request->session()->invalidate(); // Membatalkan sesi yang sedang berjalan

        $request->session()->regenerateToken(); // Membuat token baru untuk keamanan

        return redirect('/login'); // Arahkan pengguna kembali ke halaman login
    }
}
