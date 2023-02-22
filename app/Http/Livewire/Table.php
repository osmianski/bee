<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

abstract class Table extends Component
{
    public function render()
    {
        return view('livewire.table', [
            'note' => $this->getNote(),
            'columns' => collect($this->getColumns())
                ->map(fn(array $data, string $name) => new Table\Column(
                    array_merge($data, ['name' => $name]))),
            'data' => $this->getData(),
        ]);
    }

    protected function getNote(): ?string
    {
        return null;
    }

    protected abstract function getColumns(): array;
    protected abstract function getData(): LengthAwarePaginator;
}
