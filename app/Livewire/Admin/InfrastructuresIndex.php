<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Sarana')]
class InfrastructuresIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'sort_order';

    #[Url]
    public string $sortDirection = 'asc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $count = '1';

    public string $unit = 'unit';

    public string $icon = 'anchor';

    public string $category = 'perikanan';

    public string $description = '';

    public string $sort_order = '0';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = Infrastructure::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->count = (string) $item->count;
        $this->unit = $item->unit;
        $this->icon = (string) ($item->icon ?? 'anchor');
        $this->category = $item->category;
        $this->description = (string) ($item->description ?? '');
        $this->sort_order = (string) $item->sort_order;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'count' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
        if ($this->editingId) {
            Infrastructure::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Sarana diperbarui.');
        } else {
            Infrastructure::query()->create($validated);
            session()->flash('status', 'Sarana ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        Infrastructure::query()->findOrFail($id)->delete();
        session()->flash('status', 'Sarana dihapus.');
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
        $this->count = '1';
        $this->unit = 'unit';
        $this->icon = 'anchor';
        $this->category = 'perikanan';
        $this->description = '';
        $this->sort_order = '0';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'count', 'sort_order', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.infrastructures-index', ['items' => $this->applySorting(Infrastructure::query())->paginate(12)]);
    }
}
