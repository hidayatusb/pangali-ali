<?php

namespace App\Models;

use Database\Factories\DownloadableFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['title', 'category', 'file_path', 'file_name', 'file_size', 'description', 'published_at'])]
class Downloadable extends Model
{
    /** @use HasFactory<DownloadableFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function fileUrl(): ?string
    {
        if ($this->file_path === null) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }
}
