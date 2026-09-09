<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-surface font-sans antialiased">
    <div class="min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-40 hidden h-dvh w-64 flex-col bg-ocean-900 text-white lg:flex">
            <div class="border-b border-white/10 px-5 py-5">
                <p class="text-sm font-bold">Panel Admin</p>
                <p class="text-xs text-ocean-200">Pangali-Ali</p>
            </div>
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Ringkasan</a>
                <a href="{{ route('admin.profiles') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.profiles') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Profil</a>
                <a href="{{ route('admin.population') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.population') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Kependudukan</a>
                <a href="{{ route('admin.potentials') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.potentials') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Potensi</a>
                <a href="{{ route('admin.infrastructures') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.infrastructures') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Sarana</a>
                <a href="{{ route('admin.welfare') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.welfare') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Kesejahteraan</a>
                <a href="{{ route('admin.plans') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.plans') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Perencanaan</a>
                <a href="{{ route('admin.productions') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.productions') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Produksi</a>
                <a href="{{ route('admin.commodities') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.commodities') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Komoditas</a>
                <a href="{{ route('admin.map-zones') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.map-zones') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Zona Peta</a>
                <a href="{{ route('admin.news') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.news') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Berita</a>
                <a href="{{ route('admin.downloadables') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.downloadables') ? 'bg-ocean-600' : 'hover:bg-white/10' }}">Unduhan</a>
            </nav>
            <div class="border-t border-white/10 p-4 space-y-2">
                <a href="{{ route('home') }}" class="block text-sm text-ocean-200 hover:text-white">← Lihat Dashboard Publik</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-300 hover:text-red-200">Keluar</button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen min-w-0 flex-col lg:ml-64">
            <header class="flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:px-6">
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ $title ?? 'Administrasi' }}</p>
                    <p class="text-xs text-slate-500">Kelola data monografi kelurahan</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-50 lg:hidden">Publik</a>
                    <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                </div>
            </header>
            <main class="flex-1 p-4 lg:p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
