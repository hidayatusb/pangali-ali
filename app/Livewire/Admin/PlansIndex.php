<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\DevelopmentPlan;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Perencanaan')]
class PlansIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'year';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $year = '2025';

    public string $status = 'rencana';

    public string $description = '';

    public string $budget = '';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = DevelopmentPlan::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->year = (string) $item->year;
        $this->status = $item->status;
        $this->description = (string) ($item->description ?? '');
        $this->budget = (string) ($item->budget ?? '');
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ]);
        if ($this->editingId) {
            DevelopmentPlan::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Rencana diperbarui.');
        } else {
            DevelopmentPlan::query()->create($validated);
            session()->flash('status', 'Rencana ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        DevelopmentPlan::query()->findOrFail($id)->delete();
        session()->flash('status', 'Rencana dihapus.');
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
        $this->year = '2025';
        $this->status = 'rencana';
        $this->description = '';
        $this->budget = '';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['title', 'year', 'status', 'budget', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.plans-index', ['items' => $this->applySorting(DevelopmentPlan::query())->paginate(12)]);
    }
}
