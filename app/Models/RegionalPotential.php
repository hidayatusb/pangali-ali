<?php

namespace App\Models;

use Database\Factories\RegionalPotentialFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'category', 'description', 'icon'])]
class RegionalPotential extends Model
{
    /** @use HasFactory<RegionalPotentialFactory> */
    use HasFactory;
}
