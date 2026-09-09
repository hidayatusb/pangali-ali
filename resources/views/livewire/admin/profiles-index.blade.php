<div>
    <x-page-header title="Kelola Profil" subtitle="Profil Kelurahan Pangali-Ali" />
    <form wire:submit="save" class="max-w-3xl space-y-3 rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
        <div class="grid gap-3 md:grid-cols-2">
            <div><label class="mb-1 block text-xs font-medium">Nama</label><input wire:model="name" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" required></div>
            <div><label class="mb-1 block text-xs font-medium">Lurah</label><input wire:model="lurah_name" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"></div>
            <div><label class="mb-1 block text-xs font-medium">Kecamatan</label><input wire:model="district" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"></div>
            <div><label class="mb-1 block text-xs font-medium">Kabupaten</label><input wire:model="regency" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"></div>
            <div><label class="mb-1 block text-xs font-medium">Provinsi</label><input wire:model="province" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"></div>
            <div><label class="mb-1 block text-xs font-medium">Luas (km²)</label><input type="number" step="0.01" wire:model="area_km2" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2"></div>
        </div>
        <div><label class="mb-1 block text-xs font-medium">Deskripsi</label><textarea wire:model="description" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="2"></textarea></div>
        <div><label class="mb-1 block text-xs font-medium">Visi</label><textarea wire:model="vision" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="2"></textarea></div>
        <div><label class="mb-1 block text-xs font-medium">Misi</label><textarea wire:model="mission" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="3"></textarea></div>
        <div><label class="mb-1 block text-xs font-medium">Sejarah</label><textarea wire:model="history" class="w-full rounded-lg border border-ocean-200 px-3 py-2 text-sm outline-none ring-ocean-500 focus:border-ocean-500 focus:ring-2" rows="3"></textarea></div>
        <button class="rounded-lg bg-ocean-600 px-4 py-2 text-sm font-semibold text-white">Simpan Profil</button>
    </form>
</div>
