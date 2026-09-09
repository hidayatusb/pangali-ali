<div>
    <x-page-header title="Laporan & Unduhan" subtitle="Dokumen dan data monografi yang dapat diunduh" />

    <div class="space-y-3">
        @forelse ($items as $item)
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="dl-{{ $item->id }}">
                <div>
                    <h2 class="font-bold text-slate-900">{{ $item->title }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $item->description }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $item->category }} · {{ $item->file_name }} · {{ $item->published_at?->translatedFormat('d M Y') }}</p>
                </div>
                @if ($item->file_path)
                    <a href="{{ $item->fileUrl() }}" download="{{ $item->file_name }}" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white hover:bg-ocean-700">Unduh</a>
                @else
                    <span class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-500">File belum diunggah</span>
                @endif
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada dokumen.</p>
        @endforelse
    </div>
</div>
