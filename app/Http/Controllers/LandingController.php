<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Jika user sudah login, langsung arahkan ke dashboard
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // Jika belum login, tampilkan halaman landing
        return view('landing');
    }
}
