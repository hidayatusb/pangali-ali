<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <x-page-header title="Kelola Berita" subtitle="Berita dan pengumuman" />
        <button type="button" wire:click="create" class="rounded-xl bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">+ Tambah</button>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($showForm)
        <form wire:submit="save" class="mb-6 space-y-3 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm" enctype="multipart/form-data">
            <div>
                <label class="mb-1 block text-xs font-medium">Judul</label>
                <input wire:model="title" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium">Ringkasan</label>
                <textarea wire:model="excerpt" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="2"></textarea>
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium">Isi</label>
                <textarea wire:model="body" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="4"></textarea>
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium">
                    Foto / Gambar
                    @if ($editingId)
                        <span class="font-normal text-slate-500">(opsional — kosongkan jika tidak diganti)</span>
                    @endif
                </label>
                <input
                    type="file"
                    wire:model="image"
                    accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-ocean-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-ocean-700 hover:file:bg-ocean-100"
                >
                <div wire:loading wire:target="image" class="mt-1 text-xs text-ocean-600">Mengunggah gambar...</div>
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-slate-400">JPG, PNG, atau WebP. Maks. 5 MB.</p>

                @if ($image)
                    <div class="mt-3 overflow-hidden rounded-lg border border-ocean-100">
                        <img src="{{ $image->temporaryUrl() }}" alt="Pratinjau" class="h-40 w-full object-cover">
                    </div>
                @elseif ($existingImageUrl)
                    <div class="mt-3 space-y-2">
                        <div class="overflow-hidden rounded-lg border border-ocean-100">
                            <img src="{{ $existingImageUrl }}" alt="Gambar berita" class="h-40 w-full object-cover">
                        </div>
                        <button type="button" wire:click="removeImage" wire:confirm="Hapus gambar berita ini?" class="text-xs font-semibold text-red-600 hover:underline">
                            Hapus gambar
                        </button>
                    </div>
                @endif
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-medium">Tanggal Terbit</label>
                    <input type="date" wire:model="published_at" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required>
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="is_published" class="rounded"> Publikasikan</label>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white" wire:loading.attr="disabled">Simpan</button>
                <button type="button" wire:click="cancel" class="rounded-lg border border-ocean-200 px-4 py-2 text-sm">Batal</button>
            </div>
        </form>
    @endif

    <div class="overflow-hidden rounded-xl border border-ocean-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-ocean-200 bg-ocean-50 text-xs text-ocean-800">
                <tr>
                    <th class="px-4 py-3">Gambar</th>
                    <x-sortable-th column="title" label="Judul" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="published_at" label="Tanggal" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <x-sortable-th column="is_published" label="Status" :sort-by="$sortBy" :sort-direction="$sortDirection" />
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t border-ocean-100" wire:key="news-{{ $item->id }}">
                        <td class="px-4 py-3">
                            @if ($item->imageUrl())
                                <img src="{{ $item->imageUrl() }}" alt="" class="h-12 w-16 rounded-md object-cover">
                            @else
                                <span class="inline-flex h-12 w-16 items-center justify-center rounded-md bg-ocean-50 text-[10px] text-ocean-500">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $item->title }}</td>
                        <td class="px-4 py-3">{{ $item->published_at?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $item->is_published ? 'Terbit' : 'Draf' }}</td>
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
