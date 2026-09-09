<?php

namespace App\Livewire\Pages;

use App\Models\MapZone;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Peta Interaktif')]
class Peta extends Component
{
    public function render()
    {
        return view('livewire.pages.peta', [
            'zones' => MapZone::query()->get(),
            'zonesJson' => MapZone::query()->get()->map(fn (MapZone $zone): array => [
                'name' => $zone->name,
                'color' => $zone->color,
                'lat' => (float) $zone->latitude,
                'lng' => (float) $zone->longitude,
                'description' => $zone->description,
            ])->values()->all(),
        ]);
    }
}
