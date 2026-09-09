<div>
    {{-- Hero --}}
    <section class="relative mb-6 overflow-hidden rounded-2xl shadow-md">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1600&q=80"
                alt="Perahu nelayan"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/80 to-ocean-900/40"></div>
        </div>
        <div class="relative grid gap-6 p-6 md:grid-cols-[1.4fr_0.8fr] md:p-10 lg:min-h-[280px] lg:items-center">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 md:text-4xl">
                    Dashboard Monografi Kelurahan Pangali-Ali
                </h1>
                <p class="mt-3 text-base font-medium text-slate-700 md:text-lg">
                    Data Nelayan untuk Perencanaan Pembangunan yang Lebih Baik
                </p>
                <p class="mt-3 max-w-xl text-sm italic text-slate-600">
                    "Data yang akurat, laut yang lestari, masyarakat yang sejahtera."
                </p>
            </div>
            <div class="rounded-2xl bg-ocean-700/90 p-6 text-white shadow-lg backdrop-blur-sm">
                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-semibold leading-relaxed md:text-base">
                    Bersama Membangun Kelurahan Pangali-Ali Berbasis Data.
                </p>
            </div>
        </div>
    </section>

    {{-- KPI --}}
    <section class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <x-kpi-card label="Jumlah Penduduk" :value="$kpis['population']['value']" :change="$kpis['population']['change']" icon-color="bg-sky-100 text-sky-700">
            <x-slot:iconSlot>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </x-slot:iconSlot>
        </x-kpi-card>
        <x-kpi-card label="Jumlah Nelayan" :value="$kpis['fishermen']['value']" :change="$kpis['fishermen']['change']" icon-color="bg-blue-100 text-blue-700">
            <x-slot:iconSlot>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m0 12a7 7 0 01-7-7h2a5 5 0 0010 0h2a7 7 0 01-7 7zm0 0V9"/></svg>
            </x-slot:iconSlot>
        </x-kpi-card>
        <x-kpi-card label="Jumlah Armada" :value="$kpis['fleets']['value']" :change="$kpis['fleets']['change']" icon-color="bg-indigo-100 text-indigo-700">
            <x-slot:iconSlot>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l3-9h12l3 9M5 17h14M8 17v2m8-2v2"/></svg>
            </x-slot:iconSlot>
        </x-kpi-card>
        <x-kpi-card label="Produksi Perikanan" :value="$kpis['production']['value']" :change="$kpis['production']['change']" icon-color="bg-cyan-100 text-cyan-700">
            <x-slot:iconSlot>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </x-slot:iconSlot>
        </x-kpi-card>
        <x-kpi-card label="Nilai Ekonomi Perikanan" :value="$kpis['economy']['value']" :change="$kpis['economy']['change']" icon-color="bg-emerald-100 text-emerald-700">
            <x-slot:iconSlot>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:iconSlot>
        </x-kpi-card>
    </section>

    {{-- Charts + Map --}}
    <section class="mb-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm lg:col-span-1">
            <div class="mb-4 flex items-center justify-between gap-2">
                <h2 class="text-sm font-bold text-slate-800">Produksi Perikanan (Ton)</h2>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">5 Tahun Terakhir</span>
            </div>
            <div class="h-56">
                <canvas id="productionChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Jenis Komoditas Perikanan</h2>
            <div class="relative mx-auto h-48 w-48">
                <canvas id="commodityChart"></canvas>
                <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                    <p class="text-lg font-bold text-slate-900">{{ number_format($commodityChart['total'], 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500">Ton</p>
                </div>
            </div>
            <ul class="mt-4 space-y-1.5">
                @foreach ($commodityChart['labels'] as $i => $label)
                    <li class="flex items-center justify-between text-xs text-slate-600">
                        <span class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $commodityChart['colors'][$i] }}"></span>
                            {{ $label }}
                        </span>
                        <span class="font-semibold">{{ number_format($commodityChart['values'][$i], 0) }}%</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800">Peta Wilayah Kelurahan</h2>
                <a href="{{ route('peta') }}" class="rounded-lg bg-ocean-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-ocean-700">Lihat Peta Interaktif</a>
            </div>
            <div id="homeMap" class="h-56 overflow-hidden rounded-xl border border-slate-200"></div>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($mapZones as $zone)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-2 py-1 text-[10px] font-medium text-slate-600">
                        <span class="h-2 w-2 rounded-full" style="background: {{ $zone->color }}"></span>
                        {{ $zone->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Bottom row --}}
    <section class="grid gap-4 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Jumlah Nelayan Berdasarkan Kelompok Usia</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs text-slate-500">
                            <th class="pb-2 font-medium">Kelompok Usia</th>
                            <th class="pb-2 font-medium">Jumlah</th>
                            <th class="pb-2 font-medium">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ageGroups as $group)
                            <tr class="border-b border-slate-50">
                                <td class="py-2.5 text-slate-700">{{ $group['label'] }}</td>
                                <td class="py-2.5 font-semibold text-slate-900">{{ number_format($group['count'], 0, ',', '.') }}</td>
                                <td class="py-2.5 text-ocean-700">{{ number_format($group['percent'], 1, ',', '.') }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Sarana dan Prasarana Perikanan</h2>
            <ul class="space-y-3">
                @foreach ($infrastructures as $item)
                    <li class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2.5">
                        <span class="flex items-center gap-3 text-sm font-medium text-slate-700">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-ocean-100 text-ocean-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                            </span>
                            {{ $item->name }}
                        </span>
                        <span class="text-sm font-bold text-slate-900">{{ $item->count }} {{ $item->unit }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800">Berita & Pengumuman</h2>
                <a href="{{ route('berita.index') }}" class="text-xs font-semibold text-ocean-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-1" id="berita">
                @forelse ($news as $post)
                    <x-news-item
                        :title="$post->title"
                        :date="$post->published_at?->translatedFormat('d M Y')"
                        :image="$post->imageUrl()"
                        :href="route('berita.show', $post)"
                    />
                @empty
                    <p class="text-sm text-slate-500">Belum ada berita.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const productionCtx = document.getElementById('productionChart');
            if (productionCtx && window.Chart) {
                new Chart(productionCtx, {
                    type: 'line',
                    data: {
                        labels: @json($productionChart['labels']),
                        datasets: [{
                            label: 'Ton',
                            data: @json($productionChart['values']),
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.12)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: false, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const commodityCtx = document.getElementById('commodityChart');
            if (commodityCtx && window.Chart) {
                new Chart(commodityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($commodityChart['labels']),
                        datasets: [{
                            data: @json($commodityChart['values']),
                            backgroundColor: @json($commodityChart['colors']),
                            borderWidth: 0,
                            cutout: '68%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }

            const mapEl = document.getElementById('homeMap');
            if (mapEl && window.L) {
                const map = L.map(mapEl, { zoomControl: false, attributionControl: false }).setView([-3.54, 118.97], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
                const zones = @json($mapZonesJson);
                zones.forEach((zone) => {
                    if (zone.lat && zone.lng) {
                        L.circleMarker([zone.lat, zone.lng], {
                            radius: 10,
                            color: zone.color,
                            fillColor: zone.color,
                            fillOpacity: 0.65,
                            weight: 2
                        }).bindPopup(zone.name).addTo(map);
                    }
                });
            }
        });
    </script>
@endpush
