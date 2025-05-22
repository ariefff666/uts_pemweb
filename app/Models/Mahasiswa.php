<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; // Menyatakan nama tabel yang benar (singular)

    protected $primaryKey = 'nim'; // Set primary key
    public $incrementing = false; // Karena nim bukan auto-increment
    protected $keyType = 'string'; // Tipe data PK adalah string

    protected $fillable = [
        'nim', 'user_id', 'nama', 'prodi', 'semester'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function absensis()
    {
        // Pastikan foreign key dan local key sudah benar
        return $this->hasMany(Absensi::class, 'mahasiswa_nim', 'nim');
    }

    // Fungsi untuk menghitung total kehadiran (sesuai permintaan soal)
    public function getTotalKehadiran(string $matakuliahIdMk, string $status = 'Hadir'): int
    {
        return $this->absensis()
                    ->where('matakuliah_id_mk', $matakuliahIdMk)
                    ->where('status_kehadiran', $status)
                    ->count();
    }

    // Fungsi untuk menghitung persentase kehadiran
    public function getPersentaseKehadiran(string $matakuliahIdMk, int $totalPertemuan): float
    {
        if ($totalPertemuan == 0) {
            return 0;
        }
        $hadir = $this->getTotalKehadiran($matakuliahIdMk, 'Hadir');
        return ($hadir / $totalPertemuan) * 100;
    }
}
