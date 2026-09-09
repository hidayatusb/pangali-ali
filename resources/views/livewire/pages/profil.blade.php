<div>
    <x-page-header title="Profil Kelurahan" subtitle="Informasi umum Kelurahan Pangali-Ali" />

    @if ($profile)
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-lg font-bold text-slate-900">{{ $profile->name }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $profile->district }}, {{ $profile->regency }}, {{ $profile->province }}</p>
                <p class="mt-4 text-sm leading-relaxed text-slate-700">{{ $profile->description }}</p>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-bold text-ocean-800">Visi</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $profile->vision }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-ocean-800">Misi</h3>
                        <pre class="mt-2 whitespace-pre-wrap font-sans text-sm text-slate-600">{{ $profile->mission }}</pre>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-bold text-ocean-800">Sejarah Singkat</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $profile->history }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">Luas Wilayah</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format((float) $profile->area_km2, 2, ',', '.') }} km²</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">Lurah</p>
                    <p class="mt-1 text-lg font-bold text-slate-900">{{ $profile->lurah_name }}</p>
                </div>
            </div>
        </div>
    @else
        <p class="text-sm text-slate-500">Profil kelurahan belum tersedia.</p>
    @endif
</div>
