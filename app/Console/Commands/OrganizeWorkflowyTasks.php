<?php

namespace App\Console\Commands;

use App\Integrations\Workflowy;
use Illuminate\Console\Command;

class OrganizeWorkflowyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workflowy:organize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Organize workflowy tasks, see https://workflowy.com/#/fea979048554';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $workflowy = new Workflowy();
        $topNodes = $workflowy->query();

        $topNodes
            ->whereName('/^..\s+Projects$/u')
            ->children()
            ->whereTodo()
            ->each(fn($project) => $this->addBreadcrumbsToChildren($project));

        return Command::SUCCESS;
    }

    /**
     * @param Workflowy\Query $project
     * @param Workflowy\Query[] $parents
     * @return void
     */
     protected function addBreadcrumbsToChildren(Workflowy\Query $project,
        array $parents = []): void
    {
        $parents[] = $project;

        $project
            ->children()
            ->whereTodo()
            ->each(fn($task) => $this->addBreadcrumbsTo($task, $parents));
    }

    /**
     * @param Workflowy\Query $task
     * @param Workflowy\Query[] $parents
     * @return void
     */
    protected function addBreadcrumbsTo(Workflowy\Query $task, array $parents)
        : void
    {
        $this->output->writeln($task->name());

        $breadcrumbs = '';
        foreach ($parents as $parent) {
            if ($breadcrumbs) {
                $breadcrumbs .= ' > ';
            }
            $breadcrumbs .= $parent->internalLink();
        }
        $this->output->writeln($breadcrumbs);
        $this->output->writeln('');

        $this->addBreadcrumbsToChildren($task, $parents);
    }
}
