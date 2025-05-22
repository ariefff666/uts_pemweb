<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-2 sm:mb-0">
                Laporan Absensi: {{ $matakuliah->nama_mk }}
            </h2>
            @if(count($attendanceData) > 0) {{-- Tombol export hanya muncul jika ada data --}}
            <a href="{{ route('dosen.absensi.export', $matakuliah->id_mk) }}" class="inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-400 active:bg-teal-600 focus:outline-none focus:border-teal-600 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Excel
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Rekapitulasi Absensi</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 rounded-md">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIM</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Mahasiswa</th>
                                @if(count($uniqueDates) > 0)
                                    @foreach($uniqueDates as $date)
                                        <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">{{ $date->format('d M Y') }}</th>
                                    @endforeach
                                @else
                                    <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pertemuan</th>
                                @endif
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Hadir</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($attendanceData as $data)
                            <tr class="{{ $data['show_warning'] ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $data['mahasiswa']->nim }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $data['mahasiswa']->nama }}</td>
                                @if(count($uniqueDates) > 0)
                                    @foreach($uniqueDates as $date)
                                        <td class="px-2 py-4 text-center whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $data['records'][$date->format('Y-m-d')] ?? '-' }}
                                        </td>
                                    @endforeach
                                @else
                                     <td class="px-2 py-4 text-center whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">-</td>
                                @endif
                                <td class="px-4 py-4 text-center whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $data['total_hadir'] }}</td>
                                <td class="px-4 py-4 text-center whitespace-nowrap text-sm font-semibold {{ $data['show_warning'] ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ $data['persentase_kehadiran'] }}%
                                    @if($data['show_warning'])
                                        <span class="block text-xs text-red-500 dark:text-red-500">(Di bawah 75%)</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 4 + count($uniqueDates) }}" class="px-6 py-10 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Belum ada data absensi untuk mata kuliah ini.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Perbaikan di sini: Menggunakan count() PHP untuk array atau collection --}}
                @if(isset($mahasiswaHadirTerakhir) && count($mahasiswaHadirTerakhir) > 0)
                <hr class="my-8 border-gray-300 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Daftar Mahasiswa Hadir (Pertemuan Terakhir:
                    @if($mahasiswaHadirTerakhir->first() && $mahasiswaHadirTerakhir->first()->tanggal)
                        {{ $mahasiswaHadirTerakhir->first()->tanggal->format('d F Y') }}
                    @else
                        N/A
                    @endif
                    )
                </h3>
                <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                    @foreach ($mahasiswaHadirTerakhir as $absen)
                        <li>{{ $absen->mahasiswa->nama ?? 'Nama Mahasiswa Tidak Tersedia' }} ({{ $absen->mahasiswa->nim ?? 'NIM Tidak Tersedia' }})</li>
                    @endforeach
                </ul>
                @elseif(count($uniqueDates) > 0) {{-- Hanya tampilkan jika ada pertemuan tercatat tapi tidak ada yang hadir di pertemuan terakhir --}}
                <hr class="my-8 border-gray-300 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Daftar Mahasiswa Hadir (Pertemuan Terakhir)
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tidak ada mahasiswa yang tercatat hadir pada pertemuan terakhir.</p>
                @endif

                <div class="mt-8">
                    <a href="{{ route('dosen.absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
