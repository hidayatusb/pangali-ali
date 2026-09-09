<?php

namespace App\Models;

use Database\Factories\CommodityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'percentage', 'tonnage', 'color', 'year'])]
class Commodity extends Model
{
    /** @use HasFactory<CommodityFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'percentage' => 'decimal:2',
            'tonnage' => 'decimal:2',
            'year' => 'integer',
        ];
    }
}
