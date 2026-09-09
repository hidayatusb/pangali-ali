<?php

namespace App\Livewire\Admin;

use App\Models\VillageProfile;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Kelola Profil')]
class ProfilesIndex extends Component
{
    public string $name = '';

    public string $district = '';

    public string $regency = '';

    public string $province = '';

    public string $vision = '';

    public string $mission = '';

    public string $history = '';

    public string $description = '';

    public string $area_km2 = '';

    public string $lurah_name = '';

    public function mount(): void
    {
        $profile = VillageProfile::query()->first();
        if ($profile) {
            $this->fill($profile->only([
                'name', 'district', 'regency', 'province', 'vision', 'mission', 'history', 'description', 'lurah_name',
            ]));
            $this->area_km2 = (string) ($profile->area_km2 ?? '');
        }
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'regency' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'area_km2' => ['nullable', 'numeric', 'min:0'],
            'lurah_name' => ['nullable', 'string', 'max:255'],
        ]);

        $profile = VillageProfile::query()->first();
        if ($profile) {
            $profile->update($validated);
        } else {
            VillageProfile::query()->create($validated);
        }

        session()->flash('status', 'Profil kelurahan disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.profiles-index');
    }
}
