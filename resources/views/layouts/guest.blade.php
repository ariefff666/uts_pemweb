<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Absensi Mahasiswa') }} - Autentikasi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-50 dark:from-gray-800 dark:via-gray-900 dark:to-slate-900">
            <div>
                <a href="/">
                    <svg class="h-20 w-20 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m0 0A8.489 8.489 0 0019.5 12c0-4.682-3.818-8.494-8.5-8.494A8.489 8.489 0 004.5 12a8.489 8.489 0 007.5 7.747M12 6.253c0-1.657 1.343-3 3-3s3 1.343 3 3M12 6.253c0-1.657-1.343-3-3-3s-3 1.343-3 3m6 14.5V12a3 3 0 013-3h0a3 3 0 013 3v6.747m-6 0A8.489 8.489 0 004.5 12c0-4.682 3.818-8.494 8.5-8.494A8.489 8.489 0 0119.5 12a8.489 8.489 0 01-7.5 7.747" />
                    </svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                    Daftar di sini
                </a>
            </div>
            <div class="mt-2 text-center text-xs text-gray-500 dark:text-gray-500">
                 &copy; {{ date('Y') }} {{ config('app.name', 'Sistem Absensi Mahasiswa') }}.
            </div>
        </div>
    </body>
</html>
