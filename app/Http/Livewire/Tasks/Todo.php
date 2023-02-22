<?php

namespace App\Http\Livewire\Tasks;

use App\Http\Livewire\Tasks;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Todo extends Tasks
{
    protected function getQuery(): QueryBuilder|EloquentBuilder
    {
        return parent::getQuery()
            ->where('tasks.type', '=', Task\Type::Todo);
    }
}
