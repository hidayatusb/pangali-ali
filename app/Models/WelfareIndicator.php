<?php

namespace App\Models;

use Database\Factories\WelfareIndicatorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'value', 'unit', 'year', 'notes'])]
class WelfareIndicator extends Model
{
    /** @use HasFactory<WelfareIndicatorFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }
}
