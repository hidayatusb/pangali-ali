<?php

namespace App\Livewire\Admin;

use App\Models\Fisherman;
use App\Models\FisheryProduction;
use App\Models\Fleet;
use App\Models\NewsPost;
use App\Services\DashboardStatsService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Ringkasan Admin')]
class Dashboard extends Component
{
    public function render(DashboardStatsService $stats)
    {
        return view('livewire.admin.dashboard', [
            'kpis' => $stats->kpis(),
            'fishermenCount' => Fisherman::query()->count(),
            'fleetTotal' => (int) Fleet::query()->sum('count'),
            'newsCount' => NewsPost::query()->count(),
            'latestProduction' => FisheryProduction::query()->orderByDesc('year')->first(),
        ]);
    }
}
