<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResidentsTemplateExport implements FromArray, ShouldAutoSize, WithHeadings
{
    use Exportable;

    /**
     * @return list<list<string>>
     */
    public function array(): array
    {
        return [];
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
}
