<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah'; // Menyatakan nama tabel yang benar (singular)

    protected $primaryKey = 'id_mk'; // Set primary key
    public $incrementing = false; // Bukan auto-increment
    protected $keyType = 'string'; // Tipe data PK adalah string

    protected $fillable = [
        'id_mk', 'nama_mk', 'sks', 'semester'
    ];

    public function absensis()
    {
        // Pastikan foreign key dan local key sudah benar
        return $this->hasMany(Absensi::class, 'matakuliah_id_mk', 'id_mk');
    }
}
