<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Fisherman;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Nelayan')]
class FishermenIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $nik = '';

    public string $age = '';

    public string $gender = 'laki-laki';

    public string $address = '';

    public string $boat_type = '';

    public string $phone = '';

    public bool $is_active = true;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        Gate::authorize('admin');
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        Gate::authorize('admin');
        $fisherman = Fisherman::query()->findOrFail($id);
        $this->editingId = $fisherman->id;
        $this->name = $fisherman->name;
        $this->nik = (string) ($fisherman->nik ?? '');
        $this->age = (string) $fisherman->age;
        $this->gender = $fisherman->gender;
        $this->address = (string) ($fisherman->address ?? '');
        $this->boat_type = (string) ($fisherman->boat_type ?? '');
        $this->phone = (string) ($fisherman->phone ?? '');
        $this->is_active = $fisherman->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:32', 'unique:fishermen,nik,'.$this->editingId],
            'age' => ['required', 'integer', 'min:15', 'max:100'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'address' => ['nullable', 'string', 'max:255'],
            'boat_type' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        $validated['nik'] = $validated['nik'] !== '' ? $validated['nik'] : null;

        if ($this->editingId) {
            Fisherman::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Data nelayan diperbarui.');
        } else {
            Fisherman::query()->create($validated);
            session()->flash('status', 'Data nelayan ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        Fisherman::query()->findOrFail($id)->delete();
        session()->flash('status', 'Data nelayan dihapus.');
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
        $this->nik = '';
        $this->age = '';
        $this->gender = 'laki-laki';
        $this->address = '';
        $this->boat_type = '';
        $this->phone = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'age', 'boat_type', 'is_active', 'created_at'];
    }

    public function render()
    {
        $fishermen = Fisherman::query()
            ->when($this->search !== '', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));

        $fishermen = $this->applySorting($fishermen)->paginate(12);

        return view('livewire.admin.fishermen-index', [
            'fishermen' => $fishermen,
        ]);
    }
}
