<?php

namespace App\Livewire\Admin;

use App\Models\FisheryProduction;
use App\Models\NewsPost;
use App\Models\Resident;
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
            'residentCount' => Resident::query()->count(),
            'fishermenCount' => Resident::query()->fishermen()->count(),
            'newsCount' => NewsPost::query()->count(),
            'latestProduction' => FisheryProduction::query()->orderByDesc('year')->first(),
        ]);
    }
}
