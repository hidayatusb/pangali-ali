<?php

namespace App\Models;

use Database\Factories\FishermanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'nik', 'age', 'gender', 'address', 'boat_type', 'phone', 'is_active'])]
class Fisherman extends Model
{
    /** @use HasFactory<FishermanFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function ageGroupLabel(): string
    {
        return match (true) {
            $this->age >= 15 && $this->age <= 24 => '15–24 tahun',
            $this->age >= 25 && $this->age <= 34 => '25–34 tahun',
            $this->age >= 35 && $this->age <= 44 => '35–44 tahun',
            $this->age >= 45 && $this->age <= 54 => '45–54 tahun',
            default => '≥55 tahun',
        };
    }
}
