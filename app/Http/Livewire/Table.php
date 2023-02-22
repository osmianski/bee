<?php

namespace App\Http\Livewire;

use Livewire\Component;

abstract class Table extends Component
{
    public function render()
    {
        return view('livewire.table', [
            'note' => $this->getNote(),
            'columns' => array_map(fn(array $data) => new Table\Column($data),
                $this->getColumns()),
        ]);
    }

    protected function getNote(): ?string
    {
        return null;
    }

    protected abstract function getColumns(): array;
}
