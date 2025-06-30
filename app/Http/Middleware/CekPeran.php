<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPeran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$peran): Response
    {
        // Cek apakah user sudah login DAN perannya ada di dalam daftar peran yang diizinkan
        if ($request->user() && in_array($request->user()->peran, $peran)) {
            // Jika diizinkan, lanjutkan pengguna ke tujuan berikutnya
            return $next($request);
        }

        // Jika tidak diizinkan, tendang kembali ke halaman dashboard
        // dengan sebuah pesan error.
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
    }
}
