<?php

namespace App\Models;

use Database\Factories\FisheryProductionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['year', 'total_ton', 'economic_value'])]
class FisheryProduction extends Model
{
    /** @use HasFactory<FisheryProductionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'total_ton' => 'decimal:2',
            'economic_value' => 'decimal:2',
        ];
    }
}
