<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\WelfareIndicator;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Kesejahteraan')]
class WelfareIndex extends Component
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

    public string $value = '';

    public string $unit = '';

    public string $year = '2024';

    public string $notes = '';

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $item = WelfareIndicator::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->value = $item->value;
        $this->unit = (string) ($item->unit ?? '');
        $this->year = (string) $item->year;
        $this->notes = (string) ($item->notes ?? '');
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:100'],
            'unit' => ['nullable', 'string', 'max:50'],
            'year' => ['required', 'integer'],
            'notes' => ['nullable', 'string'],
        ]);
        if ($this->editingId) {
            WelfareIndicator::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Indikator diperbarui.');
        } else {
            WelfareIndicator::query()->create($validated);
            session()->flash('status', 'Indikator ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        WelfareIndicator::query()->findOrFail($id)->delete();
        session()->flash('status', 'Indikator dihapus.');
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
        $this->value = '';
        $this->unit = '';
        $this->year = '2024';
        $this->notes = '';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'value', 'year', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.welfare-index', ['items' => $this->applySorting(WelfareIndicator::query())->paginate(12)]);
    }
}
