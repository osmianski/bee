<?php

namespace App\Http\Livewire\Tasks;

use App\Http\Livewire\Tasks;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Calendar extends Tasks
{
    protected function getColumns(): array
    {
        return array_merge(parent::getColumns(), [
            'planned_at' => [
                'title' => 'Planned At',
            ],
        ]);
    }

    protected function getQuery(): QueryBuilder|EloquentBuilder
    {
        return parent::getQuery()
            ->where('tasks.type', '=', Task\Type::Calendar)
            ->addSelect('tasks.planned_at AS planned_at');
    }
}
