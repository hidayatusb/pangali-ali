<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\RegionalPotential;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Potensi')]
class PotentialsIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $category = '';

    public string $description = '';

    public string $icon = 'leaf';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = RegionalPotential::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->category = (string) ($item->category ?? '');
        $this->description = (string) ($item->description ?? '');
        $this->icon = (string) ($item->icon ?? 'leaf');
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);
        if ($this->editingId) {
            RegionalPotential::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Potensi diperbarui.');
        } else {
            RegionalPotential::query()->create($validated);
            session()->flash('status', 'Potensi ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        RegionalPotential::query()->findOrFail($id)->delete();
        session()->flash('status', 'Potensi dihapus.');
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
        $this->category = '';
        $this->description = '';
        $this->icon = 'leaf';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['title', 'category', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.potentials-index', ['items' => $this->applySorting(RegionalPotential::query())->paginate(12)]);
    }
}
