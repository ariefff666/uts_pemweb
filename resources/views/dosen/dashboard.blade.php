<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        👋 Selamat Datang, {{ Auth::user()->dosen->nama ?? Auth::user()->name }}!
                    </h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        Ini adalah pusat kendali Anda untuk mengelola absensi dan informasi perkuliahan.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Dosen</h4>
                            @if(Auth::user()->dosen)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">NIP:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->dosen->nip }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Nama Lengkap:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->dosen->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Email:</span>
                                    <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-600 dark:text-gray-400">Data profil dosen tidak ditemukan.</p>
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
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Statistik Cepat</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Mata Kuliah</p>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ \App\Models\Matakuliah::count() }}</p>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Mahasiswa Terdaftar</p>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ \App\Models\Mahasiswa::count() }}</p>
                                </div>
                                {{-- Tambahkan statistik lain jika perlu --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Utama</h4>
                            <a href="{{ route('dosen.absensi.index') }}"
                               class="flex items-center justify-between w-full p-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg transition duration-150 ease-in-out text-white shadow-md">
                                <div>
                                    <h5 class="font-semibold">Kelola Absensi Mahasiswa</h5>
                                    <p class="text-sm opacity-90">Input, lihat laporan, dan ekspor data.</p>
                                </div>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            {{-- Tambahkan link aksi lainnya jika ada --}}
                            {{--
                            <a href="#"
                               class="mt-3 flex items-center justify-between w-full p-4 bg-sky-500 hover:bg-sky-600 dark:bg-sky-500 dark:hover:bg-sky-600 rounded-lg transition duration-150 ease-in-out text-white shadow-md">
                                <div>
                                    <h5 class="font-semibold">Manajemen Mata Kuliah (Contoh)</h5>
                                    <p class="text-sm opacity-90">Lihat dan kelola daftar mata kuliah.</p>
                                </div>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            --}}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pengumuman</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Belum ada pengumuman penting saat ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
