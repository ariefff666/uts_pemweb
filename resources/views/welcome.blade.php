<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Absensi Mahasiswa') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Anda bisa menambahkan sedikit custom CSS di sini jika perlu,
           misalnya untuk gradient atau efek spesifik yang sulit dengan utility Tailwind */
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-icon {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 0.75rem;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <svg class="h-8 w-auto mr-2 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m0 0A8.489 8.489 0 0019.5 12c0-4.682-3.818-8.494-8.5-8.494A8.489 8.489 0 004.5 12a8.489 8.489 0 007.5 7.747M12 6.253c0-1.657 1.343-3 3-3s3 1.343 3 3M12 6.253c0-1.657-1.343-3-3-3s-3 1.343-3 3m6 14.5c0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5m3 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5m-3-1.5V12a3 3 0 013-3h0a3 3 0 013 3v6.747m-6 0A8.489 8.489 0 004.5 12c0-4.682 3.818-8.494 8.5-8.494A8.489 8.489 0 0119.5 12a8.489 8.489 0 01-7.5 7.747" />
                            </svg>
                            <span class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ config('app.name', 'Sistem Absensi') }}</span>
                        </a>
                    </div>
                    <div>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 underline">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 underline">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow">
            <section class="hero-gradient text-white py-20 sm:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-6">
                        Sistem Absensi Mahasiswa Modern
                    </h1>
                    <p class="text-lg sm:text-xl text-indigo-200 mb-10 max-w-2xl mx-auto">
                        Kelola kehadiran perkuliahan dengan mudah, efisien, dan transparan. Dosen dapat mencatat absensi secara online, dan mahasiswa dapat melihat riwayat kehadirannya kapan saja.
                    </p>
                    <div>
                        @guest
                        <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-50 text-lg transition duration-150 ease-in-out mr-4 mb-4 sm:mb-0">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="inline-block bg-indigo-500 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-400 text-lg transition duration-150 ease-in-out">
                            Masuk
                        </a>
                        @else
                         <a href="{{ url('/dashboard') }}" class="inline-block bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-50 text-lg transition duration-150 ease-in-out">
                            Masuk ke Dashboard
                        </a>
                        @endguest
                    </div>
                </div>
            </section>

            <section class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">
                            Fitur Unggulan Kami
                        </h2>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Dirancang untuk kemudahan dosen dan mahasiswa.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                            <div class="feature-icon text-indigo-500 dark:text-indigo-300">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Absensi Online Real-time</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Dosen dapat melakukan input absensi dengan cepat dan mudah melalui form online.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                            <div class="feature-icon text-indigo-500 dark:text-indigo-300">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Riwayat Kehadiran Mahasiswa</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Mahasiswa dapat memantau rekapitulasi dan persentase kehadirannya sendiri.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                            <div class="feature-icon text-indigo-500 dark:text-indigo-300">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Notifikasi & Laporan</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Sistem dapat memberikan notifikasi persentase kehadiran dan dosen dapat mengunduh laporan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16 bg-indigo-600 dark:bg-indigo-700">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        Siap Meningkatkan Efisiensi Perkuliahan?
                    </h2>
                    <p class="mt-4 text-lg text-indigo-200">
                        Bergabunglah sekarang dan rasakan kemudahan pengelolaan absensi.
                    </p>
                    <div class="mt-8">
                         @guest
                        <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-50 text-lg transition duration-150 ease-in-out">
                            Mulai Gratis
                        </a>
                        @else
                         <a href="{{ url('/dashboard') }}" class="inline-block bg-white text-indigo-600 font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-50 text-lg transition duration-150 ease-in-out">
                            Buka Dashboard Anda
                        </a>
                        @endguest
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 dark:bg-gray-900 text-gray-400 dark:text-gray-500 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Sistem Absensi Mahasiswa') }}. All rights reserved.</p>
                <p class="text-sm">Dibangun dengan <span class="text-red-500">&hearts;</span> menggunakan Laravel & Tailwind CSS.</p>
            </div>
        </footer>
    </div>
</body>
</html>