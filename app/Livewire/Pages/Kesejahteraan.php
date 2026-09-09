<?php

namespace App\Livewire\Pages;

use App\Models\WelfareIndicator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Kesejahteraan')]
class Kesejahteraan extends Component
{
    public function render()
    {
        return view('livewire.pages.kesejahteraan', [
            'indicators' => WelfareIndicator::query()->orderByDesc('year')->get(),
        ]);
    }
}
