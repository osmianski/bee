<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Tasks extends Table
{
    protected function getColumns(): array
    {
        return [
            'project_name' => [
                'title' => 'Project',
            ],
            'name' => [
                'title' => 'Name',
            ],
            'description' => [
                'title' => 'Description',
            ],
        ];
    }

    protected function getQuery(): QueryBuilder|EloquentBuilder
    {
        return Task::query()
            ->leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->select([
                'tasks.name AS name',
                'tasks.description AS description',
                'projects.name AS project_name',
            ])
            ->where('has_children', '=', false)
            ->orderBy('projects.position')
            ->orderBy('tasks.position');
    }

    protected function getData(): LengthAwarePaginator
    {
        return $this->getQuery()->paginate();
    }
}
