<?php

namespace App\Services;

use App\Models\Commodity;
use App\Models\Fisherman;
use App\Models\FisheryProduction;
use App\Models\Infrastructure;
use App\Models\NewsPost;
use App\Models\Resident;
use Illuminate\Support\Collection;

class DashboardStatsService
{
    /**
     * @return array{population: array{value: string, change: string|null}, fishermen: array{value: string, change: string|null}, production: array{value: string, change: string|null}, economy: array{value: string, change: string|null}}
     */
    public function kpis(): array
    {
        $populationTotal = Resident::query()->count();
        $fishermenCount = Resident::query()->fishermen()->count();

        $latestProduction = FisheryProduction::query()->orderByDesc('year')->first();
        $previousProduction = FisheryProduction::query()->orderByDesc('year')->skip(1)->first();

        return [
            'population' => [
                'value' => number_format($populationTotal, 0, ',', '.'),
                'change' => null,
            ],
            'fishermen' => [
                'value' => number_format($fishermenCount, 0, ',', '.'),
                'change' => null,
            ],
            'production' => [
                'value' => number_format((float) ($latestProduction?->total_ton ?? 0), 0, ',', '.').' Ton',
                'change' => $this->formatChange($this->percentChange($previousProduction?->total_ton, $latestProduction?->total_ton)),
            ],
            'economy' => [
                'value' => $this->formatEconomy((float) ($latestProduction?->economic_value ?? 0)),
                'change' => $this->formatChange($this->percentChange($previousProduction?->economic_value, $latestProduction?->economic_value)),
            ],
        ];
    }

    /**
     * @return array{labels: list<int|string>, values: list<float>}
     */
    public function productionChart(): array
    {
        $rows = FisheryProduction::query()->orderBy('year')->get(['year', 'total_ton']);

        return [
            'labels' => $rows->pluck('year')->all(),
            'values' => $rows->map(fn (FisheryProduction $row): float => (float) $row->total_ton)->all(),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<float>, colors: list<string>, total: float}
     */
    public function commodityChart(?int $year = null): array
    {
        $year ??= (int) (Commodity::query()->max('year') ?? now()->year);
        $rows = Commodity::query()->where('year', $year)->orderByDesc('percentage')->get();

        return [
            'labels' => $rows->pluck('name')->all(),
            'values' => $rows->map(fn (Commodity $row): float => (float) $row->percentage)->all(),
            'colors' => $rows->pluck('color')->all(),
            'total' => (float) $rows->sum('tonnage'),
        ];
    }

    /**
     * @return list<array{label: string, count: int, percent: float}>
     */
    public function fishermenByAgeGroup(): array
    {
        $groups = [
            '15–24 tahun' => [15, 24],
            '25–34 tahun' => [25, 34],
            '35–44 tahun' => [35, 44],
            '45–54 tahun' => [45, 54],
            '≥55 tahun' => [55, 200],
        ];

        $total = max(Fisherman::query()->active()->count(), 1);
        $result = [];

        foreach ($groups as $label => [$min, $max]) {
            $count = Fisherman::query()->active()->whereBetween('age', [$min, $max])->count();
            $result[] = [
                'label' => $label,
                'count' => $count,
                'percent' => round(($count / $total) * 100, 1),
            ];
        }

        return $result;
    }

    /**
     * @return Collection<int, Infrastructure>
     */
    public function infrastructures(): Collection
    {
        return Infrastructure::query()->orderBy('sort_order')->get();
    }

    /**
     * @return Collection<int, NewsPost>
     */
    public function latestNews(int $limit = 3): Collection
    {
        return NewsPost::query()->published()->orderByDesc('published_at')->limit($limit)->get();
    }

    private function percentChange(int|float|string|null $previous, int|float|string|null $current): ?float
    {
        if ($previous === null || $current === null || (float) $previous == 0.0) {
            return null;
        }

        return round((((float) $current - (float) $previous) / (float) $previous) * 100, 1);
    }

    private function formatChange(?float $percent): ?string
    {
        if ($percent === null) {
            return null;
        }

        $formatted = number_format(abs($percent), 1, ',', '.');

        return ($percent >= 0 ? '↑ ' : '↓ ').$formatted.'%';
    }

    private function formatEconomy(float $value): string
    {
        if ($value >= 1_000_000_000) {
            return 'Rp '.number_format($value / 1_000_000_000, 1, ',', '.').' Miliar';
        }

        return 'Rp '.number_format($value, 0, ',', '.');
    }
}
