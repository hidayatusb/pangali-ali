<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\MapZone;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Zona Peta')]
class MapZonesIndex extends Component
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

    public string $type = 'fishing';

    public string $color = '#3b82f6';

    public string $latitude = '';

    public string $longitude = '';

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
        $item = MapZone::query()->findOrFail($id);
        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->type = $item->type;
        $this->color = $item->color;
        $this->latitude = (string) ($item->latitude ?? '');
        $this->longitude = (string) ($item->longitude ?? '');
        $this->description = (string) ($item->description ?? '');
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);
        if ($this->editingId) {
            MapZone::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Zona diperbarui.');
        } else {
            MapZone::query()->create($validated);
            session()->flash('status', 'Zona ditambahkan.');
        }
        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        MapZone::query()->findOrFail($id)->delete();
        session()->flash('status', 'Zona dihapus.');
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
        $this->type = 'fishing';
        $this->color = '#3b82f6';
        $this->latitude = '';
        $this->longitude = '';
        $this->description = '';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'type', 'created_at'];
    }

    public function render()
    {
        return view('livewire.admin.map-zones-index', ['items' => $this->applySorting(MapZone::query())->paginate(12)]);
    }
}
