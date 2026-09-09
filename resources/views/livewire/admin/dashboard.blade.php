<div>
    <x-page-header title="Ringkasan Admin" subtitle="Kelola data monografi dari satu tempat" />

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-xs text-slate-500">Penduduk</p>
            <p class="mt-1 text-2xl font-bold">{{ number_format($residentCount, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-xs text-slate-500">Nelayan</p>
            <p class="mt-1 text-2xl font-bold">{{ number_format($fishermenCount, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-xs text-slate-500">Produksi Terakhir</p>
            <p class="mt-1 text-2xl font-bold">{{ number_format((float) ($latestProduction?->total_ton ?? 0), 0, ',', '.') }} Ton</p>
        </div>
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-xs text-slate-500">Berita</p>
            <p class="mt-1 text-2xl font-bold">{{ number_format($newsCount, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            ['Profil', 'admin.profiles'],
            ['Kependudukan', 'admin.population'],
            ['Potensi', 'admin.potentials'],
            ['Sarana', 'admin.infrastructures'],
            ['Kesejahteraan', 'admin.welfare'],
            ['Perencanaan', 'admin.plans'],
            ['Produksi', 'admin.productions'],
            ['Komoditas', 'admin.commodities'],
            ['Zona Peta', 'admin.map-zones'],
            ['Berita', 'admin.news'],
            ['Unduhan', 'admin.downloadables'],
        ] as [$label, $route])
            <a href="{{ route($route) }}" class="rounded-xl border border-slate-100 bg-white px-4 py-3 text-sm font-semibold text-ocean-800 shadow-sm hover:border-ocean-200 hover:bg-ocean-50">
                Kelola {{ $label }} →
            </a>
        @endforeach
    </div>
</div>
