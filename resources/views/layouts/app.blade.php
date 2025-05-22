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
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        {{-- Wrapper utama dengan flex-col dan min-h-screen --}}
        <div x-data="{ openMobileMenu: false }" class="flex flex-col min-h-screen">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ Auth::check() ? (Auth::user()->role == 'dosen' ? route('dosen.dashboard') : route('mahasiswa.dashboard')) : url('/') }}">
                                    <svg class="h-8 w-auto text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m0 0A8.489 8.489 0 0019.5 12c0-4.682-3.818-8.494-8.5-8.494A8.489 8.489 0 004.5 12a8.489 8.489 0 007.5 7.747M12 6.253c0-1.657 1.343-3 3-3s3 1.343 3 3M12 6.253c0-1.657-1.343-3-3-3s-3 1.343-3 3m6 14.5V12a3 3 0 013-3h0a3 3 0 013 3v6.747m-6 0A8.489 8.489 0 004.5 12c0-4.682 3.818-8.494 8.5-8.494A8.489 8.489 0 0119.5 12a8.489 8.489 0 01-7.5 7.747" />
                                    </svg>
                                </a>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                @auth
                                    @php
                                        $role = Auth::user()->role;
                                        $desktopLinkBase = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';
                                        $desktopLinkActive = 'border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100 focus:border-indigo-700';
                                        $desktopLinkInactive = 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:text-gray-700 focus:border-gray-300';
                                    @endphp

                                    @if($role == 'dosen')
                                        <a href="{{ route('dosen.dashboard') }}" class="{{ $desktopLinkBase }} {{ request()->routeIs('dosen.dashboard*') ? $desktopLinkActive : $desktopLinkInactive }}">
                                            {{ __('Dosen Dashboard') }}
                                        </a>
                                        <a href="{{ route('dosen.absensi.index') }}" class="{{ $desktopLinkBase }} {{ request()->routeIs('dosen.absensi.*') ? $desktopLinkActive : $desktopLinkInactive }}">
                                            {{ __('Kelola Absensi') }}
                                        </a>
                                    @elseif($role == 'mahasiswa')
                                        <a href="{{ route('mahasiswa.dashboard') }}" class="{{ $desktopLinkBase }} {{ request()->routeIs('mahasiswa.dashboard*') ? $desktopLinkActive : $desktopLinkInactive }}">
                                            {{ __('Mahasiswa Dashboard') }}
                                        </a>
                                        <a href="{{ route('mahasiswa.riwayat.index') }}" class="{{ $desktopLinkBase }} {{ request()->routeIs('mahasiswa.riwayat.*') ? $desktopLinkActive : $desktopLinkInactive }}">
                                            {{ __('Riwayat Absensi') }}
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                           @auth
                            <div x-data="{ openDropdown: false }" class="relative">
                                <button @click="openDropdown = ! openDropdown" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                                <div x-show="openDropdown"
                                     @click.away="openDropdown = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                                     style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-gray-700">
                                        <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                            {{ __('Profil Saya') }}
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                                {{ __('Log Out') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                             @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                @endif
                            @endauth
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                           @auth
                            <button @click="openMobileMenu = ! openMobileMenu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': openMobileMenu, 'inline-flex': ! openMobileMenu }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! openMobileMenu, 'inline-flex': openMobileMenu }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>

                @auth
                <div :class="{'block': openMobileMenu, 'hidden': ! openMobileMenu}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @php
                            $role = Auth::user()->role;
                            $mobileLinkBase = 'flex items-center w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out';
                            $mobileLinkActive = 'border-indigo-400 dark:border-indigo-600 text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700';
                            $mobileLinkInactive = 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300';
                            $mobileIconBase = 'flex-shrink-0 w-6 h-6 me-3';
                            $mobileIconActive = 'text-indigo-600 dark:text-indigo-400';
                            $mobileIconInactive = 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300';
                        @endphp

                        @if($role == 'dosen')
                            <a href="{{ route('dosen.dashboard') }}" class="{{ $mobileLinkBase }} {{ request()->routeIs('dosen.dashboard*') ? $mobileLinkActive : $mobileLinkInactive }}">
                                <svg class="{{ $mobileIconBase }} {{ request()->routeIs('dosen.dashboard*') ? $mobileIconActive : $mobileIconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                <span>{{ __('Dosen Dashboard') }}</span>
                            </a>
                            <a href="{{ route('dosen.absensi.index') }}" class="{{ $mobileLinkBase }} {{ request()->routeIs('dosen.absensi.*') ? $mobileLinkActive : $mobileLinkInactive }}">
                                <svg class="{{ $mobileIconBase }} {{ request()->routeIs('dosen.absensi.*') ? $mobileIconActive : $mobileIconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>{{ __('Kelola Absensi') }}</span>
                            </a>
                        @elseif($role == 'mahasiswa')
                            <a href="{{ route('mahasiswa.dashboard') }}" class="{{ $mobileLinkBase }} {{ request()->routeIs('mahasiswa.dashboard*') ? $mobileLinkActive : $mobileLinkInactive }}">
                                <svg class="{{ $mobileIconBase }} {{ request()->routeIs('mahasiswa.dashboard*') ? $mobileIconActive : $mobileIconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ __('Mahasiswa Dashboard') }}</span>
                            </a>
                            <a href="{{ route('mahasiswa.riwayat.index') }}" class="{{ $mobileLinkBase }} {{ request()->routeIs('mahasiswa.riwayat.*') ? $mobileLinkActive : $mobileLinkInactive }}">
                                <svg class="{{ $mobileIconBase }} {{ request()->routeIs('mahasiswa.riwayat.*') ? $mobileIconActive : $mobileIconInactive }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m0 0A8.489 8.489 0 0019.5 12c0-4.682-3.818-8.494-8.5-8.494A8.489 8.489 0 004.5 12a8.489 8.489 0 007.5 7.747M12 6.253c0-1.657 1.343-3 3-3s3 1.343 3 3M12 6.253c0-1.657-1.343-3-3-3s-3 1.343-3 3m6 14.5V12a3 3 0 013-3h0a3 3 0 013 3v6.747m-6 0A8.489 8.489 0 004.5 12c0-4.682 3.818-8.494 8.5-8.494A8.489 8.489 0 0119.5 12a8.489 8.489 0 01-7.5 7.747"></path></svg>
                                <span>{{ __('Riwayat Absensi') }}</span>
                            </a>
                        @endif
                    </div>

                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block w-full ps-4 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Profil Saya') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full ps-4 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </nav>

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Menambahkan flex-grow agar konten utama mengisi ruang yang tersedia --}}
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Sistem Absensi Mahasiswa') }}. Hak Cipta Dilindungi.
                </div>
            </footer>
        </div>
    </body>
</html>
