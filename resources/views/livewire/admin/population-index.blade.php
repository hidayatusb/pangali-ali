<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <x-page-header title="Kelola Kependudukan" subtitle="Data penduduk Kelurahan Pangali-Ali" />
        <div class="flex flex-wrap gap-2">
            <button type="button" wire:click="export" class="rounded-xl border border-ocean-200 bg-white px-4 py-2 text-sm font-semibold text-ocean-800 hover:bg-ocean-50">
                Ekspor Excel
            </button>
            <button type="button" wire:click="openImport" class="rounded-xl border border-ocean-200 bg-white px-4 py-2 text-sm font-semibold text-ocean-800 hover:bg-ocean-50">
                Impor Excel
            </button>
            <button type="button" wire:click="create" class="rounded-xl bg-ocean-600 px-4 py-2 text-sm font-semibold text-white hover:bg-ocean-700">+ Tambah Penduduk</button>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-4">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Cari nama, alamat, pekerjaan, atau no HP..."
            class="w-full max-w-md rounded-xl border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"
        >
    </div>

    @if ($showImport)
        <div class="mb-6 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-2 text-sm font-bold text-slate-800">Impor Data Penduduk</h2>
            <p class="mb-4 text-xs text-slate-500">
                Unggah file .xlsx / .xls / .csv dengan kolom:
                <span class="font-medium text-slate-700">nama, alamat, pekerjaan, jenis_kelamin, no_hp, status_perkawinan, agama</span>.
                Nilai jenis kelamin: Laki-laki / Perempuan. Status: Belum Kawin, Kawin, Cerai Hidup, Cerai Mati.
                Data yang sama persis dengan data yang sudah ada akan dilewati (tidak diduplikasi).
            </p>
            <div class="mb-4 flex flex-wrap gap-2">
                <button type="button" wire:click="downloadTemplate" class="rounded-lg border border-ocean-200 px-3 py-1.5 text-xs font-semibold text-ocean-700 hover:bg-ocean-50">
                    Unduh Template Excel
                </button>
            </div>
            <form wire:submit="import" class="space-y-3">
                <div>
                    <input
                        type="file"
                        wire:model="importFile"
                        accept=".xlsx,.xls,.csv"
                        class="block w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-ocean-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-ocean-700 hover:file:bg-ocean-100"
                    >
                    <div wire:loading wire:target="importFile" class="mt-1 text-xs text-ocean-600">Mengunggah file...</div>
                    @error('importFile') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white" wire:loading.attr="disabled">Impor Sekarang</button>
                    <button type="button" wire:click="cancelImport" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button>
                </div>
            </form>
        </div>
    @endif

    @if ($showForm)
        <div class="mb-6 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">{{ $editingId ? 'Ubah' : 'Tambah' }} Penduduk</h2>
            <form wire:submit="save" class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Nama</label>
                    <input wire:model="name" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Pekerjaan</label>
                    <input wire:model="occupation" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                    @error('occupation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-medium text-slate-600">Alamat</label>
                    <input wire:model="address" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                    @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Jenis Kelamin</label>
                    <select wire:model="gender" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">No HP</label>
                    <input wire:model="phone" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" placeholder="Opsional">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Status Perkawinan</label>
                    <select wire:model="marital_status" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                        <option value="belum-kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai-hidup">Cerai Hidup</option>
                        <option value="cerai-mati">Cerai Mati</option>
                    </select>
                    @error('marital_status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Agama</label>
                    <select wire:model="religion" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                    @error('religion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-2 md:col-span-2">
                    <button type="submit" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
                    <button type="button" wire:click="cancel" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-ocean-200 bg-white shadow-sm">
        <table class="w-full min-w-[900px] text-left text-sm">
            <thead class="border-b border-ocean-200 bg-ocean-50 text-xs text-ocean-800">
                <tr>
                    <x-sortable-th column="name" label="Nama" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="address" label="Alamat" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="occupation" label="Pekerjaan" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="gender" label="Jenis Kelamin" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="phone" label="No HP" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="marital_status" label="Status Perkawinan" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="religion" label="Agama" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($residents as $resident)
                    <tr class="border-t border-ocean-100" wire:key="resident-{{ $resident->id }}">
                        <td class="px-4 py-3 font-medium">{{ $resident->name }}</td>
                        <td class="px-4 py-3">{{ $resident->address }}</td>
                        <td class="px-4 py-3">{{ $resident->occupation }}</td>
                        <td class="px-4 py-3">{{ $resident->genderLabel() }}</td>
                        <td class="px-4 py-3">{{ $resident->phone ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $resident->maritalStatusLabel() }}</td>
                        <td class="px-4 py-3">{{ $resident->religion }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <button type="button" wire:click="edit({{ $resident->id }})" class="text-ocean-600 hover:underline">Ubah</button>
                            <button type="button" wire:click="delete({{ $resident->id }})" wire:confirm="Hapus data penduduk ini?" class="ml-2 text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-slate-500">Belum ada data penduduk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $residents->links() }}</div>
</div>
