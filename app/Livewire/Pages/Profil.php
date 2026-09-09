<?php

namespace App\Livewire\Pages;

use App\Models\VillageProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Profil Kelurahan')]
class Profil extends Component
{
    public function render()
    {
        return view('livewire.pages.profil', [
            'profile' => VillageProfile::query()->first(),
        ]);
    }
}
