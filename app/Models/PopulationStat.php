<?php

namespace App\Models;

use Database\Factories\PopulationStatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['year', 'total', 'male', 'female', 'growth_percent'])]
class PopulationStat extends Model
{
    /** @use HasFactory<PopulationStatFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'total' => 'integer',
            'male' => 'integer',
            'female' => 'integer',
            'growth_percent' => 'decimal:2',
        ];
    }
}
