<div class="rounded-2xl bg-white p-8 shadow-xl shadow-ocean-950/30">
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-lg font-bold text-white">
            PA
        </div>
        <h1 class="text-xl font-bold text-slate-900">Admin Kelurahan</h1>
        <p class="mt-1 text-sm text-slate-500">Dashboard Monografi Pangali-Ali</p>
    </div>

    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input
                id="email"
                type="email"
                wire:model="email"
                class="w-full rounded-xl border border-ocean-200 px-3 py-2.5 text-sm outline-none ring-ocean-500 focus:ring-2"
                autocomplete="username"
                required
            >
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Kata Sandi</label>
            <input
                id="password"
                type="password"
                wire:model="password"
                class="w-full rounded-xl border border-ocean-200 px-3 py-2.5 text-sm outline-none ring-ocean-500 focus:ring-2"
                autocomplete="current-password"
                required
            >
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-ocean-600 focus:ring-ocean-500">
            Ingat saya
        </label>

        <button
            type="submit"
            class="w-full rounded-xl bg-ocean-600 py-2.5 text-sm font-semibold text-white hover:bg-ocean-700"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="login">Masuk</span>
            <span wire:loading wire:target="login">Memproses...</span>
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="{{ route('home') }}" class="font-medium text-ocean-600 hover:underline">Kembali ke Beranda</a>
    </p>
</div>
