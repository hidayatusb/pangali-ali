<?php

namespace App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait WithSorting
{
    /**
     * @return list<string>
     */
    abstract protected function sortableColumns(): array;

    public function sort(string $column): void
    {
        if (! in_array($column, $this->sortableColumns(), true)) {
            return;
        }

        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    protected function applySorting(Builder $query): Builder
    {
        $column = in_array($this->sortBy, $this->sortableColumns(), true)
            ? $this->sortBy
            : ($this->sortableColumns()[0] ?? 'created_at');

        $direction = $this->sortDirection === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($column, $direction);
    }
}
