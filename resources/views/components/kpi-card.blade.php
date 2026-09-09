@props([
    'label',
    'value',
    'change' => null,
    'icon' => 'chart',
    'iconColor' => 'bg-ocean-100 text-ocean-700',
])

<div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
    <div class="mb-3 flex items-start justify-between">
        <div class="{{ $iconColor }} flex h-10 w-10 items-center justify-center rounded-xl">
            {{ $iconSlot ?? '' }}
            @if (! isset($iconSlot))
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            @endif
        </div>
    </div>
    <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">{{ $label }}</p>
    <p class="mt-1 text-2xl font-bold text-slate-900">{{ $value }}</p>
    @if ($change !== null)
        <p class="mt-1 text-xs font-medium text-emerald-600">{{ $change }} dari tahun lalu</p>
    @endif
</div>
