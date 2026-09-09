<?php

namespace App\Livewire\Pages;

use App\Models\NewsPost;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class BeritaDetail extends Component
{
    public NewsPost $post;

    public function mount(NewsPost $post): void
    {
        abort_unless(
            $post->is_published
            && $post->published_at !== null
            && $post->published_at->lte(now()),
            404
        );

        $this->post = $post;
    }

    public function render()
    {
        $related = NewsPost::query()
            ->published()
            ->whereKeyNot($this->post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('livewire.pages.berita-detail', [
            'related' => $related,
        ])->title($this->post->title);
    }
}
