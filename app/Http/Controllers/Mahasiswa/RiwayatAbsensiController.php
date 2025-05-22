<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\Matakuliah;

class RiwayatAbsensiController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $absensiPerMatakuliah = Absensi::where('mahasiswa_nim', $mahasiswa->nim)
                                    ->with('matakuliah')
                                    ->orderBy('matakuliah_id_mk')
                                    ->orderBy('tanggal')
                                    ->get()
                                    ->groupBy('matakuliah_id_mk');

        $riwayatData = [];
        foreach ($absensiPerMatakuliah as $id_mk => $absensis) {
            $matakuliah = $absensis->first()->matakuliah; // Ambil data matakuliah dari salah satu absensi
            if (!$matakuliah) continue;

            // Hitung total pertemuan untuk matakuliah ini berdasarkan jumlah entri absensi unik per tanggal
            // Cara lebih akurat: Dosen harus set total pertemuan, atau kita hitung dari jumlah unik tanggal absensi di sistem
            $totalPertemuanDiSistem = Absensi::where('matakuliah_id_mk', $id_mk)
                                        ->select('tanggal')
                                        ->distinct()
                                        ->count();

            $totalHadir = $mahasiswa->getTotalKehadiran($id_mk, 'Hadir');
            $persentaseKehadiran = $mahasiswa->getPersentaseKehadiran($id_mk, $totalPertemuanDiSistem);

            $riwayatData[] = [
                'matakuliah' => $matakuliah,
                'absensis' => $absensis,
                'total_hadir' => $totalHadir,
                'total_pertemuan_matkul' => $totalPertemuanDiSistem, // Total pertemuan yang tercatat di sistem untuk matkul ini
                'persentase_kehadiran' => round($persentaseKehadiran, 2),
                'show_warning' => $persentaseKehadiran < 75 && $totalPertemuanDiSistem > 0,
            ];
        }

        return view('mahasiswa.riwayat_absensi.index', compact('mahasiswa', 'riwayatData'));
    }
}