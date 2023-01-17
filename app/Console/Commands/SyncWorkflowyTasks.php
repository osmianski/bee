<?php

namespace App\Console\Commands;

use App\Enums\Section;
use App\Exceptions\NotImplemented;
use App\Integrations\Workflowy;
use App\Integrations\Workflowy\Parser;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskId;
use App\Models\TaskTag;
use Illuminate\Console\Command;

class SyncWorkflowyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workflowy:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs Workflowy tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $workflowy = new Workflowy();

        $this->softDeleteEverything();
        $this->sync();

        return Command::SUCCESS;
    }

    protected function softDeleteEverything(): void
    {
        foreach (Tag::lazy() as $tag) {
            $tag->delete();
        }
        foreach (Category::lazy() as $category) {
            $category->delete();
        }
        foreach (Task::lazy() as $task) {
            $task->delete();
        }
        foreach (TaskTag::lazy() as $taskTag) {
            $taskTag->delete();
        }
        foreach (TaskId::lazy() as $taskId) {
            $taskId->delete();
        }
    }

    protected function sync(): void
    {
        $workflowy = new Workflowy();
        $topNodes = $workflowy->query();

        $this->syncSection($topNodes, 'Projects',
            fn($node) => $this->syncProjectNode($node));
        $this->syncSection($topNodes, 'Calendar',
            fn($node) => $this->syncCalendarNode($node));
        $this->syncSection($topNodes, 'Delegate',
            fn($node) => $this->syncDelegateNode($node));
        $this->syncSection($topNodes, 'Someday',
            fn($node) => $this->syncSomedayNode($node));
        $this->syncSection($topNodes, 'Next',
            fn($node) => $this->syncNextNode($node));
    }

    protected function syncSection(Workflowy\Query $nodes, string $name,
        callable $callback): void
    {
        $nodes
            ->whereRegex('/^..\s+' . preg_quote($name) . '$/u')
            ->children()
            ->each($callback);
    }

    protected function syncProjectNode(Workflowy\Query $node,
        Task $parent = null): void
    {
        if ($node->todo()) {
            $parent = $this->syncTask($node, parent: $parent,
                section: Section::Projects);
        }

        $node
            ->children()
            ->each(fn($node) => $this->syncProjectNode($node, $parent));
    }

    /**
     * @param Workflowy\Query $node
     * @param Workflowy\Query[] $parents
     * @return void
     */
    protected function syncCalendarNode(Workflowy\Query $node,
        array $parents = []): void
    {
        throw new NotImplemented();
    }

    /**
     * @param Workflowy\Query $node
     * @param Workflowy\Query[] $parents
     * @return void
     */
    protected function syncDelegateNode(Workflowy\Query $node,
        array $parents = []): void
    {
        throw new NotImplemented();
    }

    /**
     * @param Workflowy\Query $node
     * @param Workflowy\Query[] $parents
     * @return void
     */
    protected function syncSomedayNode(Workflowy\Query $node,
        array $parents = []): void
    {
        throw new NotImplemented();
    }

    /**
     * @param Workflowy\Query $node
     * @param Workflowy\Query[] $parents
     * @return void
     */
    protected function syncNextNode(Workflowy\Query $node,
        array $parents = []): void
    {
        throw new NotImplemented();
    }

    protected function syncTask(Workflowy\Query $node, Task $parent = null,
        Section $section = null, int $position = null,
        Category $category = null): Task
    {
        if ($taskId = TaskId::whereWorkflowyId($node->id())
            ->with('task')->first())
        {
            $taskId->restore();

            $task = $taskId->task;
            $task->restore();
        }
        elseif ($originalTaskId = TaskId::whereWorkflowyId($node->originalId())
            ->with('task')->first())
        {
            // In Workflowy, if A is an original node is deleted, one of its
            // mirrors becomes the new original node.
            //
            // That's why it's better to search original node ID matching
            // any known node ID using `TaskId::whereWorkflowyId()` method
            // rather than matching last known original node ID,
            // `Task::whereOriginalWorkflowyId()` method.

            $taskId = new TaskId();
            $taskId->workflowy_id = $node->id();

            $task = $originalTaskId->task;
            $task->restore();
        }
        else {
            $taskId = new TaskId();
            $taskId->workflowy_id = $node->id();

            $task = new Task();
        }

        $parser = new Parser($node, extractFirstDateTime: true,
            extractTags: true);

        $task->parent_id = $parent->id ?? null;
        $task->data = $node->data();
        $task->name = $parser->name();
        $task->note = $parser->note();
        $task->position = $position;
        $task->original_workflowy_id = $node->originalId();
        $task->categoryId = $category->id ?? null;
        $task->completed = $node->completed();
        $task->due_at = $parser->firstDatetime();
        $task->completed_at = $node->completedAt();

        $task->save();

        $taskId->task_id = $task->id;
        $taskId->section = $section;

        $taskId->save();

        return $task;
    }
}
