<div>
    <x-page-header title="Perencanaan Pembangunan" subtitle="Program dan rencana pembangunan berbasis data" />

    <div class="space-y-4">
        @forelse ($plans as $plan)
            <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="plan-{{ $plan->id }}">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $plan->title }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Tahun {{ $plan->year }}</p>
                    </div>
                    <span @class([
                        'rounded-full px-3 py-1 text-xs font-semibold capitalize',
                        'bg-emerald-50 text-emerald-700' => $plan->status === 'selesai',
                        'bg-blue-50 text-blue-700' => $plan->status === 'berjalan',
                        'bg-amber-50 text-amber-700' => in_array($plan->status, ['rencana', 'draft'], true),
                    ])>{{ $plan->status }}</span>
                </div>
                <p class="mt-3 text-sm text-slate-600">{{ $plan->description }}</p>
                @if ($plan->budget)
                    <p class="mt-3 text-sm font-semibold text-slate-800">Anggaran: Rp {{ number_format((float) $plan->budget, 0, ',', '.') }}</p>
                @endif
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada rencana pembangunan.</p>
        @endforelse
    </div>
</div>
