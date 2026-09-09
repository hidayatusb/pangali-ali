<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Beranda' }} — {{ config('app.name') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    @stack('styles')
    @livewireStyles
</head>
<body class="min-h-screen bg-surface" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen">
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-ocean-950/50 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <aside
            class="fixed inset-y-0 left-0 z-50 flex h-dvh w-64 flex-col bg-ocean-900 text-white transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold shadow-md">
                    PA
                </div>
                <div>
                    <p class="text-sm font-bold leading-tight">Kelurahan</p>
                    <p class="text-sm font-bold leading-tight text-ocean-200">Pangali-Ali</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                <x-sidebar-link :href="route('home')" :active="request()->routeIs('home')" icon="home">Beranda</x-sidebar-link>
                <x-sidebar-link :href="route('profil')" :active="request()->routeIs('profil')" icon="building">Profil Kelurahan</x-sidebar-link>
                <x-sidebar-link :href="route('kependudukan')" :active="request()->routeIs('kependudukan')" icon="users">Data Kependudukan</x-sidebar-link>
                <x-sidebar-link :href="route('potensi')" :active="request()->routeIs('potensi')" icon="leaf">Potensi Wilayah</x-sidebar-link>
                <x-sidebar-link :href="route('sarana')" :active="request()->routeIs('sarana')" icon="warehouse">Sarana & Prasarana</x-sidebar-link>
                <x-sidebar-link :href="route('kesejahteraan')" :active="request()->routeIs('kesejahteraan')" icon="heart">Kesejahteraan</x-sidebar-link>
                <x-sidebar-link :href="route('perencanaan')" :active="request()->routeIs('perencanaan')" icon="clipboard">Perencanaan Pembangunan</x-sidebar-link>
                <x-sidebar-link :href="route('peta')" :active="request()->routeIs('peta')" icon="map">Peta Interaktif</x-sidebar-link>
                <x-sidebar-link :href="route('berita.index')" :active="request()->routeIs('berita.*')" icon="newspaper">Berita & Pengumuman</x-sidebar-link>
                <x-sidebar-link :href="route('laporan')" :active="request()->routeIs('laporan')" icon="download">Laporan & Unduhan</x-sidebar-link>

                @auth
                    @if (auth()->user()->isAdmin())
                        <div class="my-3 border-t border-white/10 pt-3">
                            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-ocean-300">Administrasi</p>
                            <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" icon="settings">Panel Admin</x-sidebar-link>
                        </div>
                    @endif
                @endauth
            </nav>

            <div class="relative overflow-hidden border-t border-white/10 px-5 py-6">
                <div class="absolute inset-0 bg-gradient-to-t from-ocean-950/80 to-transparent"></div>
                <div class="relative">
                    <svg class="mb-2 h-10 w-full text-ocean-400/40" viewBox="0 0 120 40" fill="currentColor" aria-hidden="true">
                        <path d="M10 28c8-2 12-10 20-10s10 6 18 6 14-8 22-8 10 8 18 8 14-6 22-4v12H10V28z"/>
                        <path d="M35 22l8-10h4l-2 10h6l-14 12-4-4 6-2-4-6z"/>
                    </svg>
                    <p class="text-center text-xs font-medium italic text-ocean-200">Laut Kita, Masa Depan Kita</p>
                </div>
            </div>
        </aside>

        <div class="flex min-h-screen min-w-0 flex-col lg:ml-64">
            <header class="sticky top-0 z-30 flex items-center gap-4 border-b border-slate-200 bg-white px-4 py-3 shadow-sm lg:px-6">
                <button
                    type="button"
                    class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                    @click="sidebarOpen = !sidebarOpen"
                    aria-label="Buka menu"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <form action="{{ route('home') }}" method="GET" class="mx-auto w-full max-w-xl flex-1">
                    <div class="relative">
                        <svg class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input
                            type="search"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari data, grafik, atau informasi..."
                            class="w-full rounded-full border border-slate-200 bg-slate-50 py-2.5 pr-4 pl-10 text-sm text-slate-700 outline-none ring-ocean-500 focus:bg-white focus:ring-2"
                        >
                    </div>
                </form>

                <div class="flex shrink-0 items-center gap-3">
                    <button type="button" class="relative rounded-full p-2 text-slate-500 hover:bg-slate-100" aria-label="Notifikasi">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    @auth
                        <div class="flex items-center gap-2" x-data="{ open: false }">
                            <button type="button" class="flex items-center gap-2 rounded-full py-1 pr-2 pl-1 hover:bg-slate-50" @click="open = !open">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-ocean-600 text-xs font-bold text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <span class="hidden text-sm font-semibold text-slate-700 sm:block">{{ auth()->user()->name }}</span>
                                <svg class="hidden h-4 w-4 text-slate-400 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" class="absolute top-14 right-4 z-50 w-48 rounded-xl border border-slate-200 bg-white py-1 shadow-lg" style="display: none;">
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Panel Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full bg-ocean-600 px-4 py-2 text-sm font-semibold text-white hover:bg-ocean-700">
                            Masuk
                        </a>
                    @endauth
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}
            </main>

            <footer class="flex flex-col gap-2 border-t border-slate-200 bg-white px-4 py-4 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-6">
                <p>&copy; {{ date('Y') }} Kelurahan Pangali-Ali. Semua Hak Dilindungi.</p>
                <div class="flex gap-4">
                    <a href="{{ route('tentang') }}" class="hover:text-ocean-700">Tentang</a>
                    <a href="{{ route('kontak') }}" class="hover:text-ocean-700">Kontak</a>
                    <a href="{{ route('kebijakan-privasi') }}" class="hover:text-ocean-700">Kebijakan Privasi</a>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
