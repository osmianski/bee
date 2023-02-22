<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Tasks extends Table
{
    protected function getColumns(): array
    {
        return [
            'name' => [
                'title' => 'Name',
            ],
            'type' => [
                'title' => 'Type',
            ],
            'project_name' => [
                'title' => 'Project',
            ],
        ];
    }

    protected function getData(): LengthAwarePaginator
    {
        $query = Task::query()
            ->leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->select([
                'tasks.name AS name',
                'tasks.type AS type',
                'projects.name AS project_name',
            ])
            ->where('has_children', '=', false)
            ->orderBy('projects.position')
            ->orderBy('tasks.position');

        return $query->paginate();
    }
}
