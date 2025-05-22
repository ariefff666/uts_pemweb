<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi'; // Menyatakan nama tabel yang benar (singular)

    protected $primaryKey = 'id_absen'; // Sesuai migrasi

    protected $fillable = [
        'mahasiswa_nim', 'matakuliah_id_mk', 'tanggal', 'status_kehadiran', 'pertemuan_ke'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        // Pastikan foreign key dan owner key sudah benar
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }

    public function matakuliah()
    {
        // Pastikan foreign key dan owner key sudah benar
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id_mk', 'id_mk');
    }
}
