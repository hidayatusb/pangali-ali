<?php

namespace App\Livewire\Pages;

use App\Models\RegionalPotential;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Potensi Wilayah')]
class Potensi extends Component
{
    public function render()
    {
        return view('livewire.pages.potensi', [
            'items' => RegionalPotential::query()->latest()->get(),
        ]);
    }
}
