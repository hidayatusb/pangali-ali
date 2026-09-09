<?php

namespace App\Exports;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResidentsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(public string $search = '') {}

    /**
     * @return Builder<Resident>
     */
    public function query(): Builder
    {
        return Resident::query()
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $inner): void {
                    $inner->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%')
                        ->orWhere('occupation', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('name');
    }

    /**
     * @return list<string>
     */
    public function headings(): array
    {
        return [
            'nama',
            'alamat',
            'pekerjaan',
            'jenis_kelamin',
            'no_hp',
            'status_perkawinan',
            'agama',
        ];
    }

    /**
     * @param  Resident  $resident
     * @return list<string|null>
     */
    public function map($resident): array
    {
        return [
            $resident->name,
            $resident->address,
            $resident->occupation,
            $resident->genderLabel(),
            $resident->phone,
            $resident->maritalStatusLabel(),
            $resident->religion,
        ];
    }
}
