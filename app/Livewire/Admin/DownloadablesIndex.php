<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Downloadable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Unduhan')]
class DownloadablesIndex extends Component
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

    public string $category = 'laporan';

    public string $description = '';

    public string $published_at = '';

    public ?string $existingFileName = null;

    public TemporaryUploadedFile|string|null $file = null;

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
        $item = Downloadable::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->category = (string) ($item->category ?? 'laporan');
        $this->description = (string) ($item->description ?? '');
        $this->published_at = $item->published_at?->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->existingFileName = $item->file_name;
        $this->file = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');

        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'published_at' => ['required', 'date'],
            'file' => [
                $this->editingId ? 'nullable' : 'required',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,xls,xlsx,csv,zip,jpg,jpeg,png',
            ],
        ]);

        $data = [
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'published_at' => $validated['published_at'],
        ];

        if ($this->file instanceof TemporaryUploadedFile) {
            $data['file_path'] = $this->file->store('downloadables', 'public');
            $data['file_name'] = $this->file->getClientOriginalName();
            $data['file_size'] = $this->file->getSize();
        }

        if ($this->editingId) {
            $item = Downloadable::query()->findOrFail($this->editingId);

            if (isset($data['file_path']) && $item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }

            $item->update($data);
            session()->flash('status', 'Unduhan diperbarui.');
        } else {
            Downloadable::query()->create($data);
            session()->flash('status', 'Unduhan ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        $item = Downloadable::query()->findOrFail($id);

        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();
        session()->flash('status', 'Unduhan dihapus.');
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
        $this->category = 'laporan';
        $this->description = '';
        $this->published_at = '';
        $this->existingFileName = null;
        $this->file = null;
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['title', 'category', 'published_at', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.downloadables-index', ['items' => $this->applySorting(Downloadable::query())->paginate(12)]);
    }
}
