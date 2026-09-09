<?php

namespace App\Livewire\Pages;

use App\Models\DevelopmentPlan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Perencanaan Pembangunan')]
class Perencanaan extends Component
{
    public function render()
    {
        return view('livewire.pages.perencanaan', [
            'plans' => DevelopmentPlan::query()->orderByDesc('year')->get(),
        ]);
    }
}
