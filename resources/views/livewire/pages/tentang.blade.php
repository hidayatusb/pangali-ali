<div>
    <x-page-header title="Tentang" subtitle="Tentang Dashboard Monografi Kelurahan Pangali-Ali" />

    <div class="max-w-3xl rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
        <p class="text-sm leading-relaxed text-slate-700">
            Website ini merupakan pengembangan Dashboard Monografi Kelurahan berbasis data nelayan
            melalui pendampingan aparatur untuk perencanaan pembangunan di Kelurahan Pangali-Ali.
        </p>
        @if ($profile)
            <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $profile->description }}</p>
        @endif
        <p class="mt-4 text-sm italic text-slate-500">Laut Kita, Masa Depan Kita.</p>
    </div>
</div>
