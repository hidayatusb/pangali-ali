<?php

namespace App\Models;

use Database\Factories\InfrastructureFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'count', 'unit', 'icon', 'category', 'description', 'sort_order'])]
class Infrastructure extends Model
{
    /** @use HasFactory<InfrastructureFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'count' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
