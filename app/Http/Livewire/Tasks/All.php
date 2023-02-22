<?php

namespace App\Http\Livewire\Tasks;

use App\Http\Livewire\Tasks;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class All extends Tasks
{
    protected function getColumns(): array
    {
        return array_merge(parent::getColumns(), [
            'type' => [
                'title' => 'Type',
            ],
        ]);
    }

    protected function getQuery(): QueryBuilder|EloquentBuilder
    {
        return parent::getQuery()
            ->addSelect('tasks.type AS type');
    }
}
