@props([
    'column',
    'label',
    'sortBy',
    'sortDirection',
])

<th {{ $attributes->merge(['class' => 'px-4 py-3']) }}>
    <button
        type="button"
        wire:click="sort('{{ $column }}')"
        class="inline-flex items-center gap-1 font-medium transition hover:text-ocean-600"
    >
        <span>{{ $label }}</span>
        @if ($sortBy === $column)
            <span class="text-ocean-600" aria-hidden="true">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
            <span class="sr-only">{{ $sortDirection === 'asc' ? 'urut naik' : 'urut turun' }}</span>
        @else
            <span class="text-ocean-300" aria-hidden="true">↕</span>
        @endif
    </button>
</th>
