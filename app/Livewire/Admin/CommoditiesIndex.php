<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Commodity;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Komoditas')]
class CommoditiesIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'year';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $percentage = '';

    public string $tonnage = '';

    public string $color = '#3b82f6';

    public string $year = '2024';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = Commodity::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->percentage = (string) $item->percentage;
        $this->tonnage = (string) ($item->tonnage ?? '');
        $this->color = $item->color;
        $this->year = (string) $item->year;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'tonnage' => ['nullable', 'numeric', 'min:0'],
            'color' => ['required', 'string', 'max:20'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);
        if ($this->editingId) {
            Commodity::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Komoditas diperbarui.');
        } else {
            Commodity::query()->create($validated);
            session()->flash('status', 'Komoditas ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        Commodity::query()->findOrFail($id)->delete();
        session()->flash('status', 'Komoditas dihapus.');
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
        $this->percentage = '';
        $this->tonnage = '';
        $this->color = '#3b82f6';
        $this->year = '2024';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'percentage', 'tonnage', 'year', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.commodities-index', ['items' => $this->applySorting(Commodity::query())->paginate(12)]);
    }
}
