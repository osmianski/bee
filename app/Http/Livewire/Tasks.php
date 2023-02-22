<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Tasks extends Table
{
    public ?Task\Type $type = null;

    protected function getColumns(): array
    {
        $columns = [
            'name' => [
                'title' => 'Name',
            ],
            'description' => [
                'title' => 'Description',
            ],
        ];

        if (!$this->type) {
            $columns['type'] = [
                'title' => 'Type',
            ];
        }

        $columns['project_name'] = [
            'title' => 'Project',
        ];

        return $columns;
    }

    protected function getData(): LengthAwarePaginator
    {
        $query = Task::query()
            ->leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->select([
                'tasks.name AS name',
                'tasks.description AS description',
                'projects.name AS project_name',
            ])
            ->where('has_children', '=', false)
            ->orderBy('projects.position')
            ->orderBy('tasks.position');

        if ($this->type) {
            $query->where('tasks.type', '=', $this->type);
        }
        else {
            $query->addSelect('tasks.type AS type');
        }

        return $query->paginate();
    }
}
