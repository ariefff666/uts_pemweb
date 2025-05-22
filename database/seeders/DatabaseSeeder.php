<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Dosen;
// use App\Models\Absensi; // Absensi bisa diisi manual atau via seeder lain

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Dosen User & Dosen Profile
        $dosenUser = User::create([
            'name' => 'Rizki Kurniati',
            'email' => 'rizki.k@example.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        Dosen::create([
            'user_id' => $dosenUser->id,
            'nip' => '199001012020012001',
            'nama' => 'Rizki Kurniati, M.Kom.'
        ]);

        $dosenUser2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.s@example.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        Dosen::create([
            'user_id' => $dosenUser2->id,
            'nip' => '198505052015031002',
            'nama' => 'Dr. Budi Santoso, S.T., M.T.'
        ]);


        // Matakuliahs (minimal 5)
        Matakuliah::insert([
            ['id_mk' => 'IF201', 'nama_mk' => 'Pemrograman Web II', 'sks' => 3, 'semester' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_mk' => 'IF101', 'nama_mk' => 'Dasar Pemrograman', 'sks' => 4, 'semester' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_mk' => 'MA202', 'nama_mk' => 'Kalkulus II', 'sks' => 3, 'semester' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_mk' => 'IF303', 'nama_mk' => 'Basis Data', 'sks' => 3, 'semester' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_mk' => 'KU404', 'nama_mk' => 'Kewarganegaraan', 'sks' => 2, 'semester' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Mahasiswa Users & Mahasiswa Profiles (minimal 5)
        $mahasiswasData = [
            ['nim' => '09021182328020', 'nama' => 'Muhammad Arief Pratama', 'prodi' => 'Teknik Informatika', 'semester' => 4, 'email_suffix' => '09021182328020'],
            ['nim' => '09021182126001', 'nama' => 'Ahmad Dahlan', 'prodi' => 'Teknik Informatika', 'semester' => 8, 'email_suffix' => '09021182126001'],
            ['nim' => '09011182328002', 'nama' => 'Siti Aminah', 'prodi' => 'Sistem Informasi', 'semester' => 4, 'email_suffix' => '09021182126002'],
            ['nim' => '09011182429003', 'nama' => 'Budi Prasetyo', 'prodi' => 'Sistem Informasi', 'semester' => 2, 'email_suffix' => '09021182126003'],
            ['nim' => '09031182227004', 'nama' => 'Dewi Lestari', 'prodi' => 'Sistem Komputer', 'semester' => 6, 'email_suffix' => '09021182126004'],
            ['nim' => '09031182429005', 'nama' => 'Eko Sanjoyo', 'prodi' => 'Sistem Komputer', 'semester' => 2, 'email_suffix' => '09021182126005'],
        ];

        foreach ($mahasiswasData as $mhs) {
            $mhsUser = User::create([
                'name' => $mhs['nama'],
                'email' => $mhs['email_suffix'] . '@student.example.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);
            Mahasiswa::create([
                'user_id' => $mhsUser->id,
                'nim' => $mhs['nim'],
                'nama' => $mhs['nama'],
                'prodi' => $mhs['prodi'],
                'semester' => $mhs['semester'],
            ]);
        }
        // Panggil seeder lain jika ada
        // $this->call(AbsensiSeeder::class);
    }
}