<div>
    <div class="mb-6">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-ocean-700 hover:underline">
            ← Kembali ke daftar berita
        </a>
    </div>

    <article class="overflow-hidden rounded-2xl border border-ocean-200 bg-white shadow-sm">
        @if ($post->imageUrl())
            <div class="aspect-[21/9] w-full overflow-hidden bg-ocean-100">
                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
            </div>
        @else
            <div class="flex aspect-[21/9] w-full items-center justify-center bg-gradient-to-br from-ocean-700 to-ocean-900">
                <svg class="h-16 w-16 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        @endif

        <div class="p-6 md:p-10">
            <p class="text-sm font-medium text-ocean-600">
                {{ $post->published_at?->translatedFormat('d F Y') }}
            </p>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900 md:text-4xl">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="mt-4 text-base leading-relaxed text-slate-600 md:text-lg">
                    {{ $post->excerpt }}
                </p>
            @endif

            <div class="prose prose-slate mt-8 max-w-none whitespace-pre-line text-sm leading-7 text-slate-700 md:text-base">
                {{ $post->body }}
            </div>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="mt-8">
            <h2 class="mb-4 text-lg font-bold text-slate-900">Berita Lainnya</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($related as $item)
                    <a href="{{ route('berita.show', $item) }}" class="rounded-xl border border-ocean-200 bg-white p-4 shadow-sm transition hover:border-ocean-400 hover:shadow-md" wire:key="related-{{ $item->id }}">
                        <p class="text-xs font-medium text-ocean-600">{{ $item->published_at?->translatedFormat('d M Y') }}</p>
                        <h3 class="mt-2 line-clamp-2 text-sm font-bold text-slate-900">{{ $item->title }}</h3>
                        @if ($item->excerpt)
                            <p class="mt-2 line-clamp-2 text-xs text-slate-500">{{ $item->excerpt }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
