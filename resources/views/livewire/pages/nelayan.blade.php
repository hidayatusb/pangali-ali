<div>
    <x-page-header title="Data Nelayan" :subtitle="'Total '.$total.' nelayan aktif terdaftar'" />

    <div class="mb-4 grid gap-4 md:grid-cols-5">
        @foreach ($ageGroups as $group)
            <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                <p class="text-xs text-slate-500">{{ $group['label'] }}</p>
                <p class="mt-1 text-xl font-bold text-slate-900">{{ number_format($group['count'], 0, ',', '.') }}</p>
                <p class="text-xs text-ocean-700">{{ number_format($group['percent'], 1, ',', '.') }}%</p>
            </div>
        @endforeach
    </div>

    <div class="mb-4">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Cari nama, alamat, atau jenis armada..."
            class="w-full max-w-md rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-ocean-500 focus:ring-2"
        >
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs text-slate-500">
                <tr>
                    <th class="px-4 py-3 font-medium">Nama</th>
                    <th class="px-4 py-3 font-medium">Usia</th>
                    <th class="px-4 py-3 font-medium">Alamat</th>
                    <th class="px-4 py-3 font-medium">Jenis Armada</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fishermen as $fisherman)
                    <tr class="border-t border-slate-100" wire:key="fisherman-{{ $fisherman->id }}">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $fisherman->name }}</td>
                        <td class="px-4 py-3">{{ $fisherman->age }} th</td>
                        <td class="px-4 py-3 text-slate-600">{{ $fisherman->address }}</td>
                        <td class="px-4 py-3">{{ $fisherman->boat_type }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Tidak ada data nelayan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $fishermen->links() }}</div>
</div>
