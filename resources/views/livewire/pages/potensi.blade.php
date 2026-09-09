<div>
    <x-page-header title="Potensi Wilayah" subtitle="Potensi ekonomi, lingkungan, dan perikanan" />

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($items as $item)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="potensi-{{ $item->id }}">
                <span class="rounded-full bg-ocean-50 px-2.5 py-1 text-xs font-semibold text-ocean-700">{{ $item->category }}</span>
                <h2 class="mt-3 text-lg font-bold text-slate-900">{{ $item->title }}</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item->description }}</p>
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada data potensi.</p>
        @endforelse
    </div>
</div>
