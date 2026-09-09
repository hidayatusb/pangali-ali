<?php

namespace App\Livewire\Pages;

use App\Models\NewsPost;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
#[Title('Berita & Pengumuman')]
class BeritaIndex extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.berita-index', [
            'posts' => NewsPost::query()
                ->published()
                ->orderByDesc('published_at')
                ->paginate(9),
        ]);
    }
}
