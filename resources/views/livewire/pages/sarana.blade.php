<div>
    <x-page-header title="Sarana & Prasarana" subtitle="Fasilitas pendukung perikanan di Kelurahan Pangali-Ali" />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($items as $item)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="infra-{{ $item->id }}">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-ocean-100 text-ocean-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                </div>
                <h2 class="font-bold text-slate-900">{{ $item->name }}</h2>
                <p class="mt-1 text-2xl font-extrabold text-ocean-700">{{ $item->count }} <span class="text-sm font-medium text-slate-500">{{ $item->unit }}</span></p>
                @if ($item->description)
                    <p class="mt-2 text-sm text-slate-500">{{ $item->description }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
