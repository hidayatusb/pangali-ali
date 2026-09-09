<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <x-page-header title="Kelola Produksi" subtitle="Produksi perikanan per tahun" />
        <button type="button" wire:click="create" class="rounded-xl bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">+ Tambah</button>
    </div>
    @if ($showForm)
        <form wire:submit="save" class="mb-6 grid gap-3 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm md:grid-cols-3">
            <div><label class="mb-1 block text-xs font-medium">Tahun</label><input type="number" wire:model="year" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>@error('year')<p class="text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="mb-1 block text-xs font-medium">Total Ton</label><input type="number" step="0.01" wire:model="total_ton" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>@error('total_ton')<p class="text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div><label class="mb-1 block text-xs font-medium">Nilai Ekonomi</label><input type="number" step="0.01" wire:model="economic_value" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>@error('economic_value')<p class="text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div class="flex gap-2 md:col-span-3"><button class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">Simpan</button><button type="button" wire:click="cancel" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button></div>
        </form>
    @endif
    <div class="overflow-hidden rounded-xl border border-ocean-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-ocean-200 bg-ocean-50 text-xs text-ocean-800"><tr>
                    <x-sortable-th column="year" label="Tahun" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="total_ton" label="Ton" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="economic_value" label="Nilai Ekonomi" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <th class="px-4 py-3">Aksi</th>
                </tr></thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t border-ocean-100" wire:key="prod-{{ $item->id }}">
                        <td class="px-4 py-3 font-medium">{{ $item->year }}</td>
                        <td class="px-4 py-3">{{ number_format((float) $item->total_ton, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">Rp {{ number_format((float) $item->economic_value, 0, ',', '.') }}</td>
                        <td class="px-4 py-3"><button wire:click="edit({{ $item->id }})" class="text-ocean-600">Ubah</button> <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus?" class="ml-2 text-red-600">Hapus</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>