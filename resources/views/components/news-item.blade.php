@props([
    'title',
    'date',
    'image' => null,
    'href' => '#',
])

<a href="{{ $href }}" class="flex gap-3 rounded-lg p-2 transition hover:bg-slate-50">
    <div class="h-14 w-14 shrink-0 overflow-hidden rounded-lg bg-ocean-100">
        @if ($image)
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover">
        @else
            <div class="flex h-full w-full items-center justify-center text-ocean-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        @endif
    </div>
    <div class="min-w-0">
        <p class="line-clamp-2 text-sm font-semibold text-slate-800">{{ $title }}</p>
        <p class="mt-1 text-xs text-slate-500">{{ $date }}</p>
    </div>
</a>
