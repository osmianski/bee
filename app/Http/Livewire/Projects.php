<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Projects extends Table
{
    protected function getColumns(): array
    {
        return [
            'name' => [
                'title' => 'Name',
            ],
            'description' => [
                'title' => 'Description',
            ],
        ];
    }

    protected function getData(): LengthAwarePaginator
    {
        $query = Project::query()
            ->orderBy('position');

        return $query->paginate();
    }
}
