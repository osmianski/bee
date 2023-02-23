<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Workflowy\Node;
use Osmianski\Workflowy\Workflowy;

class PullWorkflowyWorkspace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public bool $refresh = false)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function() {
            $workflowy = new Workflowy();

            if ($this->refresh) {
                $this->markObsolete();
                $this->createProjects($workflowy->getWorkspace()->children);
                $this->deleteObsolete();
            }
            else {
                $this->mergeProjects($workflowy->getWorkspace()->children);
            }
        });
    }

    protected function mergeProjects(array $nodes): void
    {
        throw new NotImplemented();
    }

    protected function createProjects(array $nodes): void
    {
        foreach ($nodes as $node) {
            /* @var Node $node */

            $project = $this->createProject($node);
            $this->createTaskGroups($project, $node->children);
        }
    }

    protected function createProject(Node $node): Project
    {
        [$name, $type] = $this->parseProjectName($node->name);

        return Project::updateOrCreate(['workflowy_id' => $node->id], [
            'name' => mb_substr($name, 0, 255),
            'type' => $type,
            'position' => $node->position,
            'description' => $node->note,
            'is_obsolete' => false,
        ]);
    }

    protected function createTaskGroups(Project $project, array $nodes): void
    {
        foreach ($nodes as $node) {
            /* @var Node $node */

            if ($type = Task\Type::parse($node->name)) {
                $this->createTasks($project, $type, $node->children);
            }
        }
    }

    protected function parseProjectName(?string $name): array
    {
        if (!$name) {
            return ['', null];
        }

        return ($type = Project\Type::parse(mb_substr($name, 0, 1)))
            ? [mb_substr($name, 2), $type]
            : [$name, null];
    }

    protected function createTasks(Project $project, Task\Type $type,
        array $nodes, Task $parent = null): bool
    {
        foreach ($nodes as $node) {
            /* @var Node $node */

            $task = $this->createTask($project, $type, $node, $parent);
            if ($this->createTasks($project, $type, $node->children, $task)) {
                $task->update(['has_children' => true]);
            }
        }

        return !empty($nodes);
    }

    protected function createTask(Project $project, Task\Type $type, Node $node,
        ?Task $parent): Task
    {
        [$description, $plannedAt] = $this->parseTaskDescription($node->note);

        return Task::updateOrCreate(['workflowy_id' => $node->id], [
            'project_id' => $project->id,
            'parent_id' => $parent?->id,
            'name' => mb_substr($node->name, 0, 255),
            'type' => $type,
            'position' => $node->position,
            'description' => $description,
            'planned_at' => $plannedAt,
            'parent_path' => $parent
                ? ($parent->parent_path
                    ? "{$parent->parent_path} > {$parent->name}"
                    : $parent->name
                )
                : null,
            'is_obsolete' => false,
        ]);
    }

    protected function markObsolete(): void
    {
        Project::query()->update(['is_obsolete' => true]);
        Task::query()->update(['is_obsolete' => true]);
    }

    protected function deleteObsolete(): void
    {
        Project::where('is_obsolete', '=', true)->delete();
        Task::where('is_obsolete', '=', true)->delete();
    }

    protected function parseTaskDescription(?string $note): array
    {
        if (!$note) {
            return [null, null];
        }

        return ($type = Project\Type::parse(mb_substr($name, 0, 1)))
            ? [mb_substr($name, 2), $type]
            : [$name, null];
    }
}
