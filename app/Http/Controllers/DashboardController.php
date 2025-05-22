<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($user->role === 'admin') {
            // return redirect()->route('admin.dashboard'); // Jika ada admin dashboard
            return view('dashboard', ['message' => 'Admin Dashboard (Belum diimplementasi)']);
        }
        // Fallback
        return view('dashboard');
    }
}