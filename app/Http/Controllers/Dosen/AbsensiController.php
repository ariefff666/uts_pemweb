<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Mahasiswa;
use App\Models\Absensi;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiController extends Controller
{
    // Menampilkan halaman untuk memilih matakuliah dan tanggal
    public function index()
    {
        $matakuliahs = Matakuliah::orderBy('nama_mk')->get(); // Seharusnya sudah benar karena model Matakuliah sudah diupdate
        return view('dosen.absensi.index', compact('matakuliahs'));
    }

    // Menampilkan form untuk mengisi absensi mahasiswa
    public function manageAbsensi(Request $request, $matakuliah_id_mk, $tanggal)
    {
        $matakuliah = Matakuliah::findOrFail($matakuliah_id_mk); // Model sudah tahu tabel 'matakuliah'
        $parsedTanggal = Carbon::parse($tanggal);

        // Ambil semua mahasiswa (simplifikasi, idealnya mahasiswa yang terdaftar di kelas tsb)
        $mahasiswas = Mahasiswa::orderBy('nama')->get(); // Model sudah tahu tabel 'mahasiswa'

        // Ambil data absensi yang sudah ada untuk tanggal dan matkul ini
        $absensiExisting = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk) // Model sudah tahu tabel 'absensi'
                                ->where('tanggal', $parsedTanggal->toDateString())
                                ->get()
                                ->keyBy('mahasiswa_nim');

        return view('dosen.absensi.manage', compact('matakuliah', 'mahasiswas', 'parsedTanggal', 'absensiExisting'));
    }

    // Menyimpan data absensi
    public function storeAbsensi(Request $request)
    {
        $request->validate([
            // PERBAIKAN DI SINI: ganti 'matakuliahs' menjadi 'matakuliah'
            'matakuliah_id_mk' => 'required|string|exists:matakuliah,id_mk',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'absensi.*.pertemuan_ke' => 'nullable|integer|min:1',
        ]);

        $tanggal = Carbon::parse($request->tanggal)->toDateString();

        foreach ($request->absensi as $nim => $data) {
            Absensi::updateOrCreate( // Model Absensi sudah tahu tabel 'absensi'
                [
                    'mahasiswa_nim' => $nim,
                    'matakuliah_id_mk' => $request->matakuliah_id_mk,
                    'tanggal' => $tanggal,
                    // 'pertemuan_ke' => $data['pertemuan_ke'] ?? null, // Jika ingin unik per pertemuan
                ],
                [
                    'status_kehadiran' => $data['status'],
                    'pertemuan_ke' => $data['pertemuan_ke'] ?? null,
                ]
            );
        }

        return redirect()->route('dosen.absensi.manage', [$request->matakuliah_id_mk, $request->tanggal])
                         ->with('success', 'Data absensi berhasil disimpan/diperbarui.');
    }

    // Menampilkan laporan absensi per matakuliah
    public function showReport($matakuliah_id_mk)
    {
        $matakuliah = Matakuliah::findOrFail($matakuliah_id_mk);
        $mahasiswaNims = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk)
                            ->distinct()
                            ->pluck('mahasiswa_nim');
        $mahasiswas = Mahasiswa::whereIn('nim', $mahasiswaNims)->orderBy('nama')->get();

        $uniqueDates = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk)
                            ->select('tanggal')
                            ->distinct()
                            ->orderBy('tanggal')
                            ->pluck('tanggal');

        $attendanceData = [];
        foreach($mahasiswas as $mahasiswa) {
            $records = [];
            foreach($uniqueDates as $date) {
                $absen = Absensi::where('mahasiswa_nim', $mahasiswa->nim)
                                ->where('matakuliah_id_mk', $matakuliah_id_mk)
                                ->where('tanggal', $date)
                                ->first();
                $records[$date->format('Y-m-d')] = $absen ? $absen->status_kehadiran : '-';
            }
            $totalPertemuan = $uniqueDates->count();
            $totalHadir = $mahasiswa->getTotalKehadiran($matakuliah_id_mk, 'Hadir');
            $persentase = $mahasiswa->getPersentaseKehadiran($matakuliah_id_mk, $totalPertemuan);

            $attendanceData[] = [
                'mahasiswa' => $mahasiswa,
                'records' => $records,
                'total_hadir' => $totalHadir,
                'persentase_kehadiran' => round($persentase, 2),
                'show_warning' => $persentase < 75 && $totalPertemuan > 0,
            ];
        }
        
        $mahasiswaHadirTerakhir = []; // Inisialisasi sebagai array kosong
        if ($uniqueDates->isNotEmpty()) {
            $lastDate = $uniqueDates->last();
            if ($lastDate) {
                 $mahasiswaHadirTerakhir = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk)
                                            ->where('tanggal', $lastDate)
                                            ->where('status_kehadiran', 'Hadir')
                                            ->with('mahasiswa') // Eager load relasi mahasiswa
                                            ->get();
            }
        }


        return view('dosen.absensi.report', compact('matakuliah', 'attendanceData', 'uniqueDates', 'mahasiswaHadirTerakhir'));
    }

    // Export data absensi ke Excel (Fitur Bonus)
    public function exportExcel($matakuliah_id_mk)
    {
        $matakuliah = Matakuliah::findOrFail($matakuliah_id_mk);
        $mahasiswaNims = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk)
                            ->distinct()
                            ->pluck('mahasiswa_nim');
        $mahasiswas = Mahasiswa::whereIn('nim', $mahasiswaNims)->orderBy('nama')->get();

        $uniqueDates = Absensi::where('matakuliah_id_mk', $matakuliah_id_mk)
                            ->select('tanggal')
                            ->distinct()
                            ->orderBy('tanggal')
                            ->pluck('tanggal');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(str_replace(['/', '\\', '?', '*', '[', ']'], '_', $matakuliah->nama_mk)); // Sanitasi nama sheet

        // Header
        $header = ['NIM', 'Nama Mahasiswa'];
        foreach ($uniqueDates as $date) {
            $header[] = $date->format('d-M-Y');
        }
        $header[] = 'Total Hadir';
        $header[] = 'Persentase (%)';
        $sheet->fromArray($header, NULL, 'A1');

        // Auto size columns for header
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $rowNum = 2;
        foreach ($mahasiswas as $mahasiswa) {
            $rowData = [$mahasiswa->nim, $mahasiswa->nama];
            $totalPertemuan = $uniqueDates->count();
            $totalHadir = 0;

            foreach ($uniqueDates as $date) {
                $absen = Absensi::where('mahasiswa_nim', $mahasiswa->nim)
                                ->where('matakuliah_id_mk', $matakuliah_id_mk)
                                ->where('tanggal', $date)
                                ->first();
                $status = $absen ? $absen->status_kehadiran : '-';
                $rowData[] = $status;
                if ($status === 'Hadir') {
                    $totalHadir++;
                }
            }
            $persentase = ($totalPertemuan > 0) ? ($totalHadir / $totalPertemuan) * 100 : 0;
            $rowData[] = $totalHadir;
            $rowData[] = round($persentase, 2);
            $sheet->fromArray($rowData, NULL, 'A' . $rowNum++);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'absensi_' . str_replace(['/', '\\', '?', '*', '[', ']', ' '], '_', $matakuliah->nama_mk) . '.xlsx'; // Sanitasi nama file

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }
}
