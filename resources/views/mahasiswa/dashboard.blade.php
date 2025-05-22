<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">
                        👋 Selamat Datang Kembali, <span class="text-indigo-600 dark:text-indigo-400">{{ Auth::user()->name }}</span>!
                    </h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        Ini adalah halaman utama Anda. Pantau informasi akademik dan absensi Anda di sini.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Saya</h4>
                            @if($mahasiswa)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">NIM:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $mahasiswa->nim }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Nama Lengkap:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $mahasiswa->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Program Studi:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $mahasiswa->prodi }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Semester:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ $mahasiswa->semester }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Email:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-600 dark:text-gray-400">Data profil mahasiswa tidak ditemukan.</p>
                            @endif
                            <div class="mt-6 text-right">
                                 <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Akses Cepat</h4>
                            <div class="space-y-3">
                                <a href="{{ route('mahasiswa.riwayat.index') }}"
                                   class="flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-700 hover:bg-indigo-100 dark:hover:bg-indigo-600 rounded-lg transition duration-150 ease-in-out">
                                    <div>
                                        <h5 class="font-semibold text-indigo-700 dark:text-indigo-200">Riwayat Absensi Saya</h5>
                                        <p class="text-sm text-indigo-600 dark:text-indigo-300">Lihat detail kehadiran Anda per mata kuliah.</p>
                                    </div>
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                                {{-- <a href="#"
                                   class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition duration-150 ease-in-out">
                                    <div>
                                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Jadwal Kuliah (Contoh)</h5>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Lihat jadwal perkuliahan semester ini.</p>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ringkasan Absensi Umum</h4>
                             @if($mahasiswa && $mahasiswa->absensis()->count() > 0)
                                @php
                                    $totalAbsen = $mahasiswa->absensis()->count();
                                    $totalHadir = $mahasiswa->absensis()->where('status_kehadiran', 'Hadir')->count();
                                    $persentaseUmum = ($totalAbsen > 0) ? round(($totalHadir / $totalAbsen) * 100, 2) : 0;
                                @endphp
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Record Absen: <span class="font-bold text-gray-800 dark:text-gray-200">{{ $totalAbsen }}</span></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Kehadiran (Hadir): <span class="font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</span></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Persentase Kehadiran Umum:
                                        <span class="font-bold {{ $persentaseUmum >= 75 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $persentaseUmum }}%
                                        </span>
                                    </p>
                                    @if($persentaseUmum < 75 && $totalAbsen > 0)
                                    <p class="text-xs text-red-500 dark:text-red-400 mt-1">Perhatian: Persentase kehadiran umum Anda di bawah 75%. Mohon perhatikan kehadiran di setiap mata kuliah.</p>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400">Belum ada data absensi untuk ditampilkan ringkasannya.</p>
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-4">
                                * Untuk detail per mata kuliah, silakan cek Riwayat Absensi Saya.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pengumuman (Contoh)</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Saat ini belum ada pengumuman baru.
                            </p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>