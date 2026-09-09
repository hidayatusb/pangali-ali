<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Fleet;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Armada')]
class FleetsIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $type = '';

    public string $count = '0';

    public string $description = '';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = Fleet::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->type = (string) ($item->type ?? '');
        $this->count = (string) $item->count;
        $this->description = (string) ($item->description ?? '');
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'count' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        if ($this->editingId) {
            Fleet::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Armada diperbarui.');
        } else {
            Fleet::query()->create($validated);
            session()->flash('status', 'Armada ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        Fleet::query()->findOrFail($id)->delete();
        session()->flash('status', 'Armada dihapus.');
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->type = '';
        $this->count = '0';
        $this->description = '';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'type', 'count', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.fleets-index', [
            'items' => $this->applySorting(Fleet::query())->paginate(12),
        ]);
    }
}
