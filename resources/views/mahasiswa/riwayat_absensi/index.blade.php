<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Absensi: {{ $mahasiswa->nama ?? Auth::user()->name }} ({{ $mahasiswa->nim ?? 'N/A' }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(count($riwayatData) > 0)
                <div class="space-y-8">
                    @foreach($riwayatData as $data)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                <div>
                                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $data['matakuliah']->nama_mk }}
                                        <span class="text-base font-normal text-gray-500 dark:text-gray-400">({{ $data['matakuliah']->id_mk }})</span>
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Total Kehadiran: {{ $data['total_hadir'] }} / {{ $data['total_pertemuan_matkul'] }} pertemuan tercatat
                                    </p>
                                </div>
                                <div class="mt-3 sm:mt-0 text-left sm:text-right">
                                    <p class="text-lg font-bold {{ $data['show_warning'] ? 'text-red-500 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $data['persentase_kehadiran'] }}% Hadir
                                    </p>
                                    @if($data['show_warning'])
                                        <p class="text-xs font-semibold text-red-600 dark:text-red-500 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline -mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.216 3.031-1.742 3.031H4.42c-1.526 0-2.492-1.697-1.742-3.031l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1.75-5.5a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5z" clip-rule="evenodd" />
                                            </svg>
                                            PERINGATAN: Di bawah 75%
                                        </p>
                                    @else
                                        <p class="text-xs font-semibold text-green-600 dark:text-green-500 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline -mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Target Terpenuhi
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 rounded-md">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Kehadiran</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pertemuan Ke</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($data['absensis'] as $absen)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $absen->tanggal->format('d F Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                                @switch($absen->status_kehadiran)
                                                    @case('Hadir') text-green-600 dark:text-green-400 @break
                                                    @case('Sakit') text-yellow-600 dark:text-yellow-400 @break
                                                    @case('Izin') text-blue-600 dark:text-blue-400 @break
                                                    @case('Alpa') text-red-600 dark:text-red-400 @break
                                                    @default text-gray-900 dark:text-gray-100
                                                @endswitch
                                            ">{{ $absen->status_kehadiran }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $absen->pertemuan_ke ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data absensi detail untuk mata kuliah ini.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">Belum Ada Riwayat Absensi</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Riwayat absensi Anda akan muncul di sini setelah dosen melakukan pencatatan.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>