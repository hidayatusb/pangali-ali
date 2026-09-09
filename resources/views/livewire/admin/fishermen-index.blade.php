<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <x-page-header title="Kelola Nelayan" subtitle="Tambah, ubah, atau hapus data nelayan" />
        <button type="button" wire:click="create" class="rounded-xl bg-ocean-600 px-4 py-2 text-sm font-semibold text-white hover:bg-ocean-700">+ Tambah Nelayan</button>
    </div>

    <div class="mb-4">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari nama..." class="w-full max-w-sm rounded-xl border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:ring-2">
    </div>

    @if ($showForm)
        <div class="mb-6 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">{{ $editingId ? 'Ubah' : 'Tambah' }} Nelayan</h2>
            <form wire:submit="save" class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Nama</label>
                    <input wire:model="name" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">NIK</label>
                    <input wire:model="nik" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                    @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Usia</label>
                    <input type="number" wire:model="age" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                    @error('age') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Jenis Kelamin</label>
                    <select wire:model="gender" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Alamat</label>
                    <input wire:model="address" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Jenis Armada</label>
                    <input wire:model="boat_type" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Telepon</label>
                    <input wire:model="phone" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" wire:model="is_active" class="rounded border-ocean-300 text-ocean-600"> Aktif
                    </label>
                </div>
                <div class="flex gap-2 md:col-span-2">
                    <button type="submit" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
                    <button type="button" wire:click="cancel" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-ocean-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-ocean-200 bg-ocean-50 text-xs text-ocean-800">
                <tr>
                    <x-sortable-th column="name" label="Nama" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="age" label="Usia" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="boat_type" label="Armada" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="is_active" label="Status" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fishermen as $fisherman)
                    <tr class="border-t border-ocean-100" wire:key="admin-fisherman-{{ $fisherman->id }}">
                        <td class="px-4 py-3 font-medium">{{ $fisherman->name }}</td>
                        <td class="px-4 py-3">{{ $fisherman->age }}</td>
                        <td class="px-4 py-3">{{ $fisherman->boat_type }}</td>
                        <td class="px-4 py-3">{{ $fisherman->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-4 py-3">
                            <button type="button" wire:click="edit({{ $fisherman->id }})" class="text-ocean-600 hover:underline">Ubah</button>
                            <button type="button" wire:click="delete({{ $fisherman->id }})" wire:confirm="Hapus data nelayan ini?" class="ml-2 text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $fishermen->links() }}</div>
</div>
