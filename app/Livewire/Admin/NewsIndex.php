<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Berita')]
class NewsIndex extends Component
{
    use WithFileUploads;
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'published_at';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $excerpt = '';

    public string $body = '';

    public string $published_at = '';

    public bool $is_published = true;

    public TemporaryUploadedFile|string|null $image = null;

    public ?string $existingImageUrl = null;

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->published_at = now()->format('Y-m-d');
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = NewsPost::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->excerpt = (string) ($item->excerpt ?? '');
        $this->body = (string) ($item->body ?? '');
        $this->published_at = $item->published_at?->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->is_published = $item->is_published;
        $this->existingImageUrl = $item->imageUrl();
        $this->image = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');

        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'published_at' => ['required', 'date'],
            'is_published' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data = [
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'published_at' => $validated['published_at'],
            'is_published' => $validated['is_published'],
        ];

        if ($this->image instanceof TemporaryUploadedFile) {
            $data['image_path'] = $this->image->store('news', 'public');
        }

        if ($this->editingId) {
            $post = NewsPost::query()->findOrFail($this->editingId);

            if (isset($data['image_path']) && $post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $post->update($data);
            session()->flash('status', 'Berita diperbarui.');
        } else {
            $data['slug'] = Str::slug($data['title']).'-'.Str::random(4);
            NewsPost::query()->create($data);
            session()->flash('status', 'Berita ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function removeImage(): void
    {
        Gate::authorize('admin');

        if (! $this->editingId) {
            $this->existingImageUrl = null;

            return;
        }

        $post = NewsPost::query()->findOrFail($this->editingId);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
            $post->update(['image_path' => null]);
        }

        $this->existingImageUrl = null;
        $this->image = null;
        session()->flash('status', 'Gambar berita dihapus.');
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        $post = NewsPost::query()->findOrFail($id);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();
        session()->flash('status', 'Berita dihapus.');
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->title = '';
        $this->excerpt = '';
        $this->body = '';
        $this->published_at = '';
        $this->is_published = true;
        $this->image = null;
        $this->existingImageUrl = null;
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['title', 'published_at', 'is_published', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.news-index', ['items' => $this->applySorting(NewsPost::query())->paginate(12)]);
    }
}
