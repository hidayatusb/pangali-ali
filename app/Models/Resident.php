<?php

namespace App\Models;

use Database\Factories\ResidentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'address',
    'occupation',
    'gender',
    'phone',
    'marital_status',
    'religion',
])]
class Resident extends Model
{
    /** @use HasFactory<ResidentFactory> */
    use HasFactory;

    public function genderLabel(): string
    {
        return match ($this->gender) {
            'laki-laki' => 'Laki-laki',
            'perempuan' => 'Perempuan',
            default => $this->gender,
        };
    }

    public function maritalStatusLabel(): string
    {
        return match ($this->marital_status) {
            'belum-kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai-hidup' => 'Cerai Hidup',
            'cerai-mati' => 'Cerai Mati',
            default => $this->marital_status,
        };
    }
}
