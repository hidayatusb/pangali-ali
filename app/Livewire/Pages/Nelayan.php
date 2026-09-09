<?php

namespace App\Livewire\Pages;

use App\Models\Fisherman;
use App\Services\DashboardStatsService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
#[Title('Data Nelayan')]
class Nelayan extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(DashboardStatsService $stats)
    {
        $fishermen = Fisherman::query()
            ->active()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($inner) {
                    $inner->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%')
                        ->orWhere('boat_type', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.pages.nelayan', [
            'fishermen' => $fishermen,
            'ageGroups' => $stats->fishermenByAgeGroup(),
            'total' => Fisherman::query()->active()->count(),
        ]);
    }
}
