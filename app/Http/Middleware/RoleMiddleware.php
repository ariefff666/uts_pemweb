<?php

namespace App\Http\Middleware; // Pastikan namespace ini benar

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware // Pastikan nama kelas ini benar
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            // Jika role tidak cocok, redirect ke dashboard yang sesuai atau halaman default
            if ($user->role === 'dosen') {
                return redirect()->route('dosen.dashboard')->with('error', 'Akses tidak diizinkan ke halaman tersebut.');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Akses tidak diizinkan ke halaman tersebut.');
            }
            // Fallback jika role tidak dikenal atau tidak ada route dashboard spesifik
            return redirect('/dashboard')->with('error', 'Akses tidak diizinkan.');
        }
        return $next($request);
    }
}