<?php

namespace App\Livewire\Pages;

use App\Models\VillageProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Tentang')]
class Tentang extends Component
{
    public function render()
    {
        return view('livewire.pages.tentang', [
            'profile' => VillageProfile::query()->first(),
        ]);
    }
}
