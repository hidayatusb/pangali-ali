<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Kontak')]
class Kontak extends Component
{
    public function render()
    {
        return view('livewire.pages.kontak');
    }
}
