<div>
    <x-page-header title="Peta Interaktif" subtitle="Zona wilayah Kelurahan Pangali-Ali" />

    <div class="grid gap-4 lg:grid-cols-[2fr_1fr]">
        <div id="interactiveMap" class="h-[480px] overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"></div>
        <div class="space-y-3">
            @foreach ($zones as $zone)
                <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm" wire:key="zone-{{ $zone->id }}">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full" style="background: {{ $zone->color }}"></span>
                        <h2 class="font-bold text-slate-900">{{ $zone->name }}</h2>
                    </div>
                    <p class="mt-2 text-sm text-slate-600">{{ $zone->description }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $zone->type }} · {{ $zone->latitude }}, {{ $zone->longitude }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('interactiveMap');
        if (!el || !window.L) return;
        const map = L.map(el).setView([-3.54, 118.97], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        const zones = @json($zonesJson);
        zones.forEach((zone) => {
            if (!zone.lat || !zone.lng) return;
            L.circleMarker([zone.lat, zone.lng], {
                radius: 12,
                color: zone.color,
                fillColor: zone.color,
                fillOpacity: 0.7,
                weight: 2
            }).bindPopup(`<strong>${zone.name}</strong><br>${zone.description ?? ''}`).addTo(map);
        });
    });
</script>
@endpush
