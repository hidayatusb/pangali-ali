<?php

namespace App\Livewire\Pages;

use App\Models\Downloadable;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Laporan & Unduhan')]
class Laporan extends Component
{
    public function render()
    {
        return view('livewire.pages.laporan', [
            'items' => Downloadable::query()->orderByDesc('published_at')->get(),
        ]);
    }
}
