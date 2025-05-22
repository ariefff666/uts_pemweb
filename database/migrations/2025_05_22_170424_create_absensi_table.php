<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absen'); // Sesuai soal: id_absen PK, auto-increment
            $table->string('mahasiswa_nim');
            $table->string('matakuliah_id_mk');
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->integer('pertemuan_ke')->nullable(); // Tambahan opsional
            $table->timestamps();

            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('matakuliah_id_mk')->references('id_mk')->on('matakuliah')->onDelete('cascade');
            $table->unique(['mahasiswa_nim', 'matakuliah_id_mk', 'tanggal', 'pertemuan_ke'], 'absensi_unique'); // Mencegah duplikasi absensi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
