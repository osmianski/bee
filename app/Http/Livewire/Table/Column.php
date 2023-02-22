<?php

namespace App\Http\Livewire\Table;

use Illuminate\Database\Eloquent\Model;
use Osmianski\Helper\Object_;

/**
 * @property ?string $title
 */
class Column extends Object_
{
    public string $name;

    protected function get_title(): ?string
    {
        return null;
    }

    public function value(Model $item): mixed
    {
        $value = $item;

        foreach (explode('.', $this->name) as $property) {
            $value = $value->$property;
        }

        return $value;
    }
}
