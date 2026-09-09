<?php

namespace App\Livewire\Pages;

use App\Models\Infrastructure;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Sarana & Prasarana')]
class Sarana extends Component
{
    public function render()
    {
        return view('livewire.pages.sarana', [
            'items' => Infrastructure::query()->orderBy('sort_order')->get(),
        ]);
    }
}
