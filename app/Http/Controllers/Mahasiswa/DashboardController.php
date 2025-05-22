<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa; // Asumsi relasi mahasiswa() ada di User model
        // Jika Anda ingin data absensi di sini, Anda perlu mengambilnya
        // $absensiSummary = ... ; // (opsional, bisa juga dari $mahasiswa->absensis())
        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }
}