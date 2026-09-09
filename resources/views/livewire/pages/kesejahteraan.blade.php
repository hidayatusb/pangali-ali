<div>
    <x-page-header title="Kesejahteraan" subtitle="Indikator kesejahteraan masyarakat nelayan" />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($indicators as $indicator)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="welfare-{{ $indicator->id }}">
                <p class="text-xs font-medium text-slate-500">Tahun {{ $indicator->year }}</p>
                <h2 class="mt-2 font-bold text-slate-900">{{ $indicator->name }}</h2>
                <p class="mt-3 text-3xl font-extrabold text-ocean-700">
                    {{ $indicator->value }}
                    <span class="text-sm font-medium text-slate-500">{{ $indicator->unit }}</span>
                </p>
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada indikator.</p>
        @endforelse
    </div>
</div>
