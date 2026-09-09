<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\FisheryProduction;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Produksi')]
class ProductionsIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'year';

    #[Url]
    public string $sortDirection = 'desc';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $year = '';

    public string $total_ton = '';

    public string $economic_value = '';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = FisheryProduction::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->year = (string) $item->year;
        $this->total_ton = (string) $item->total_ton;
        $this->economic_value = (string) $item->economic_value;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100', 'unique:fishery_productions,year,'.$this->editingId],
            'total_ton' => ['required', 'numeric', 'min:0'],
            'economic_value' => ['required', 'numeric', 'min:0'],
        ]);

        if ($this->editingId) {
            FisheryProduction::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Produksi diperbarui.');
        } else {
            FisheryProduction::query()->create($validated);
            session()->flash('status', 'Produksi ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        FisheryProduction::query()->findOrFail($id)->delete();
        session()->flash('status', 'Produksi dihapus.');
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->year = '';
        $this->total_ton = '';
        $this->economic_value = '';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['year', 'total_ton', 'economic_value', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.productions-index', [
            'items' => $this->applySorting(FisheryProduction::query())->paginate(12),
        ]);
    }
}
