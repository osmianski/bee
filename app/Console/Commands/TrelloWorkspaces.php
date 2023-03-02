<?php

namespace App\Console\Commands;

use App\Trello\Board;
use App\Trello\Trello;
use App\Trello\Workspace;
use Illuminate\Console\Command;

class TrelloWorkspaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:workspaces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Trello workspaces';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $trello = new Trello();

        $this->table(['ID', 'Name'], collect($trello->getWorkspaces())
            ->map(fn(Workspace $workspace) => [$workspace->id, $workspace->name])
            ->toArray()
        );
    }
}
