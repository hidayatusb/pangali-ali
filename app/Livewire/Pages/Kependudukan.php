<?php

namespace App\Livewire\Pages;

use App\Models\Resident;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.dashboard')]
#[Title('Data Kependudukan')]
class Kependudukan extends Component
{
    public function render()
    {
        return view('livewire.pages.kependudukan', [
            'totalResidents' => Resident::query()->count(),
            'maleCount' => Resident::query()->where('gender', 'laki-laki')->count(),
            'femaleCount' => Resident::query()->where('gender', 'perempuan')->count(),
            'genderChart' => $this->chartByColumn('gender', [
                'laki-laki' => 'Laki-laki',
                'perempuan' => 'Perempuan',
            ], ['#2563eb', '#ec4899']),
            'occupationChart' => $this->chartByColumn('occupation', null, [
                '#2563eb', '#0ea5e9', '#14b8a6', '#22c55e', '#eab308', '#f97316', '#ef4444', '#a855f7', '#64748b',
            ]),
            'maritalChart' => $this->chartByColumn('marital_status', [
                'belum-kawin' => 'Belum Kawin',
                'kawin' => 'Kawin',
                'cerai-hidup' => 'Cerai Hidup',
                'cerai-mati' => 'Cerai Mati',
            ], ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444']),
            'religionChart' => $this->chartByColumn('religion', null, [
                '#059669', '#2563eb', '#7c3aed', '#ea580c', '#db2777', '#0891b2',
            ]),
        ]);
    }

    /**
     * @param  array<string, string>|null  $labelMap
     * @param  list<string>  $colors
     * @return array{labels: list<string>, values: list<int>, colors: list<string>}
     */
    private function chartByColumn(string $column, ?array $labelMap, array $colors): array
    {
        $allowed = ['gender', 'occupation', 'marital_status', 'religion'];

        if (! in_array($column, $allowed, true)) {
            return ['labels' => [], 'values' => [], 'colors' => []];
        }

        /** @var Collection<int, object{value: string, total: int}> $rows */
        $rows = Resident::query()
            ->selectRaw("{$column} as value, COUNT(*) as total")
            ->groupBy($column)
            ->orderByDesc('total')
            ->get();

        $labels = [];
        $values = [];
        $palette = [];

        foreach ($rows as $index => $row) {
            $key = (string) $row->value;
            $labels[] = $labelMap[$key] ?? $key;
            $values[] = (int) $row->total;
            $palette[] = $colors[$index % count($colors)];
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'colors' => $palette,
        ];
    }
}
