<div>
    <x-page-header title="Berita & Pengumuman" subtitle="Informasi terbaru dari Kelurahan Pangali-Ali" />

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <a
                href="{{ route('berita.show', $post) }}"
                class="group overflow-hidden rounded-xl border border-ocean-200 bg-white shadow-sm transition hover:border-ocean-400 hover:shadow-md"
                wire:key="berita-{{ $post->id }}"
            >
                <div class="aspect-[16/9] overflow-hidden bg-ocean-100">
                    @if ($post->imageUrl())
                        <img src="{{ $post->imageUrl() }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-ocean-600 to-ocean-800">
                            <svg class="h-10 w-10 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs font-medium text-ocean-600">{{ $post->published_at?->translatedFormat('d M Y') }}</p>
                    <h2 class="mt-2 line-clamp-2 text-base font-bold text-slate-900 group-hover:text-ocean-800">{{ $post->title }}</h2>
                    @if ($post->excerpt)
                        <p class="mt-2 line-clamp-3 text-sm text-slate-500">{{ $post->excerpt }}</p>
                    @endif
                    <span class="mt-3 inline-block text-xs font-semibold text-ocean-700">Baca selengkapnya →</span>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-500 md:col-span-2 lg:col-span-3">Belum ada berita yang dipublikasikan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
</div>
