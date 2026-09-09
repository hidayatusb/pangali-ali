@props(['title', 'subtitle' => null])

<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900 md:text-2xl">{{ $title }}</h1>
    @if ($subtitle)
        <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
