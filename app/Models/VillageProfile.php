<?php

namespace App\Models;

use Database\Factories\VillageProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'district',
    'regency',
    'province',
    'vision',
    'mission',
    'history',
    'description',
    'area_km2',
    'lurah_name',
])]
class VillageProfile extends Model
{
    /** @use HasFactory<VillageProfileFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'area_km2' => 'decimal:2',
        ];
    }
}
