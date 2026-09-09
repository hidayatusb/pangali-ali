<?php

namespace App\Models;

use Database\Factories\DevelopmentPlanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'year', 'status', 'description', 'budget'])]
class DevelopmentPlan extends Model
{
    /** @use HasFactory<DevelopmentPlanFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'budget' => 'decimal:2',
        ];
    }
}
