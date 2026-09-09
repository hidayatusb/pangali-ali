<?php

namespace App\Livewire\Pages;

use App\Models\MapZone;
use App\Services\DashboardStatsService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Beranda')]
class Beranda extends Component
{
    public function render(DashboardStatsService $stats)
    {
        return view('livewire.pages.beranda', [
            'kpis' => $stats->kpis(),
            'productionChart' => $stats->productionChart(),
            'commodityChart' => $stats->commodityChart(),
            'ageGroups' => $stats->fishermenByAgeGroup(),
            'infrastructures' => $stats->infrastructures(),
            'news' => $stats->latestNews(),
            'mapZones' => MapZone::query()->get(),
            'mapZonesJson' => MapZone::query()->get()->map(fn (MapZone $zone): array => [
                'name' => $zone->name,
                'color' => $zone->color,
                'lat' => (float) $zone->latitude,
                'lng' => (float) $zone->longitude,
            ])->values()->all(),
        ]);
    }
}
