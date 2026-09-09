<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\WithSorting;
use App\Models\Resident;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Kelola Kependudukan')]
class PopulationIndex extends Component
{
    use WithPagination;
    use WithSorting;

    #[Url]
    public string $sortBy = 'name';

    #[Url]
    public string $sortDirection = 'asc';

    #[Url]
    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $address = '';

    public string $occupation = '';

    public string $gender = 'laki-laki';

    public string $phone = '';

    public string $marital_status = 'belum-kawin';

    public string $religion = 'Islam';

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
        $resident = Resident::query()->findOrFail($id);
        $this->editingId = $resident->id;
        $this->name = $resident->name;
        $this->address = $resident->address;
        $this->occupation = $resident->occupation;
        $this->gender = $resident->gender;
        $this->phone = (string) ($resident->phone ?? '');
        $this->marital_status = $resident->marital_status;
        $this->religion = $resident->religion;
        $this->showForm = true;
    }

    public function save(): void
    {
        Gate::authorize('admin');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'phone' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['required', 'in:belum-kawin,kawin,cerai-hidup,cerai-mati'],
            'religion' => ['required', 'string', 'max:50'],
        ]);

        $validated['phone'] = $validated['phone'] !== '' ? $validated['phone'] : null;

        if ($this->editingId) {
            Resident::query()->findOrFail($this->editingId)->update($validated);
            session()->flash('status', 'Data penduduk diperbarui.');
        } else {
            Resident::query()->create($validated);
            session()->flash('status', 'Data penduduk ditambahkan.');
        }

        $this->showForm = false;
        $this->resetForm();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Gate::authorize('admin');
        Resident::query()->findOrFail($id)->delete();
        session()->flash('status', 'Data penduduk dihapus.');
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
        $this->address = '';
        $this->occupation = '';
        $this->gender = 'laki-laki';
        $this->phone = '';
        $this->marital_status = 'belum-kawin';
        $this->religion = 'Islam';
        $this->resetValidation();
    }

    /**
     * @return list<string>
     */
    protected function sortableColumns(): array
    {
        return ['name', 'address', 'occupation', 'gender', 'phone', 'marital_status', 'religion', 'created_at'];
    }

    public function render()
    {
        $residents = Resident::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($inner) {
                    $inner->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%')
                        ->orWhere('occupation', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            });

        $residents = $this->applySorting($residents)->paginate(12);

        return view('livewire.admin.population-index', [
            'residents' => $residents,
        ]);
    }
}
