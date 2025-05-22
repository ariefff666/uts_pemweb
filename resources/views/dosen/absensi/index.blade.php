<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
        >
            {{ __('Pilih Matakuliah dan Tanggal untuk Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
            >
                {{-- Form untuk memilih matakuliah dan tanggal --}}
                <div
                    class="mb-8 p-6 border border-gray-200 dark:border-gray-700 rounded-lg"
                >
                    <h3
                        class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200"
                    >
                        Input atau Edit Absensi
                    </h3>
                    <form id="formPilihAbsensi">
                        {{-- Tidak perlu @csrf jika hanya navigasi GET --}}
                        <div class="mb-4">
                            <label
                                for="matakuliah_id_mk_input"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >Matakuliah</label
                            >
                            <select
                                id="matakuliah_id_mk_input"
                                name="matakuliah_id_mk"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="">-- Pilih Matakuliah --</option>
                                @foreach($matakuliahs as $matakuliah)
                                <option value="{{ $matakuliah->id_mk }}">
                                    {{ $matakuliah->nama_mk }} ({{
                                    $matakuliah->id_mk }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label
                                for="tanggal_input"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >Tanggal Absensi</label
                            >
                            <input
                                type="date"
                                id="tanggal_input"
                                name="tanggal"
                                value="{{ date('Y-m-d') }}"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            />
                        </div>

                        <div>
                            <button
                                type="button"
                                onclick="goToManageAbsensi()"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 mr-1.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Lanjutkan ke Form Absensi
                            </button>
                        </div>
                    </form>
                </div>

                <hr class="my-8 border-gray-300 dark:border-gray-700" />

                <h3
                    class="text-xl font-semibold mb-6 text-gray-800 dark:text-gray-200"
                >
                    Laporan Absensi per Matakuliah
                </h3>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    @forelse($matakuliahs as $matakuliah)
                    <a
                        href="{{ route('dosen.absensi.report', $matakuliah->id_mk) }}"
                        class="block p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out"
                    >
                        <h5
                            class="mb-2 text-lg font-bold tracking-tight text-indigo-700 dark:text-indigo-400"
                        >
                            {{ $matakuliah->nama_mk }}
                        </h5>
                        <p
                            class="font-normal text-sm text-gray-600 dark:text-gray-400"
                        >
                            Lihat rekapitulasi dan detail absensi untuk mata
                            kuliah ini.
                        </p>
                        <div class="mt-4 text-right">
                            <span
                                class="inline-flex items-center text-xs font-semibold text-indigo-600 dark:text-indigo-300"
                            >
                                Lihat Laporan
                                <svg
                                    class="w-3 h-3 ml-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    ></path>
                                </svg>
                            </span>
                        </div>
                    </a>
                    @empty
                    <p class="text-gray-600 dark:text-gray-400 md:col-span-3">
                        Belum ada data mata kuliah.
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
        <script>
            function goToManageAbsensi() {
                // Mengambil nilai aktual dari elemen input
                const matakuliahId = document.getElementById(
                    "matakuliah_id_mk_input"
                ).value;
                const tanggal = document.getElementById("tanggal_input").value;

                // Memeriksa apakah nilai sudah dipilih
                if (matakuliahId && tanggal) {
                    // Membangun URL dengan nilai variabel yang benar
                    window.location.href = `/dosen/absensi/manage/${matakuliahId}/${tanggal}`;
                } else {
                    alert(
                        "Silakan pilih matakuliah dan tanggal terlebih dahulu."
                    );
                }
            }
        </script>
    </div>
</x-app-layout>
