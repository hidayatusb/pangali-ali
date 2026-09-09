<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <x-page-header title="Kelola Unduhan" subtitle="Dokumen laporan dan data" />
        <button type="button" wire:click="create" class="rounded-xl bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">+ Tambah</button>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($showForm)
        <form wire:submit="save" class="mb-6 grid gap-3 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm md:grid-cols-2" enctype="multipart/form-data">
            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-medium">Judul</label>
                <input wire:model="title" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium">Kategori</label>
                <input wire:model="category" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium">Tanggal</label>
                <input type="date" wire:model="published_at" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                @error('published_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-medium">
                    File dokumen
                    @if ($editingId)
                        <span class="font-normal text-slate-500">(opsional — kosongkan jika tidak diganti)</span>
                    @endif
                </label>
                <input
                    type="file"
                    wire:model="file"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.zip,.jpg,.jpeg,.png"
                    class="block w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-ocean-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-ocean-700 hover:file:bg-ocean-100"
                >
                <div wire:loading wire:target="file" class="mt-1 text-xs text-ocean-600">Mengunggah file...</div>
                @if ($existingFileName && ! $file)
                    <p class="mt-1 text-xs text-slate-500">File saat ini: <span class="font-medium text-slate-700">{{ $existingFileName }}</span></p>
                @endif
                @error('file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-slate-400">PDF, Word, Excel, CSV, ZIP, atau gambar. Maks. 10 MB.</p>
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-medium">Deskripsi</label>
                <input wire:model="description" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2">
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-2 md:col-span-2">
                <button type="submit" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white" wire:loading.attr="disabled">Simpan</button>
                <button type="button" wire:click="cancel" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button>
            </div>
        </form>
    @endif

    <div class="overflow-hidden rounded-xl border border-ocean-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-ocean-200 bg-ocean-50 text-xs text-ocean-800">
                <tr>
                    <x-sortable-th column="title" label="Judul" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="category" label="Kategori" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <th class="px-4 py-3">File</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t border-ocean-100" wire:key="dl-{{ $item->id }}">
                        <td class="px-4 py-3 font-medium">{{ $item->title }}</td>
                        <td class="px-4 py-3">{{ $item->category }}</td>
                        <td class="px-4 py-3 text-xs text-slate-600">
                            @if ($item->file_path)
                                <a href="{{ $item->fileUrl() }}" target="_blank" class="font-medium text-ocean-700 hover:underline">{{ $item->file_name ?? 'Unduh' }}</a>
                            @else
                                <span class="text-slate-400">Belum ada file</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <button wire:click="edit({{ $item->id }})" class="text-ocean-600">Ubah</button>
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus?" class="ml-2 text-red-600">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
