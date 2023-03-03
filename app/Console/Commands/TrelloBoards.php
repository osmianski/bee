<?php

namespace App\Console\Commands;

use App\Trello\Board;
use App\Trello\Trello;
use Illuminate\Console\Command;

class TrelloBoards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:boards {--open} {--closed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Trello boards';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $trello = new Trello();

        $boards = $trello->getBoards(
            open: $this->option('open')
                ? true
                : ($this->option('closed')
                    ? false
                    : null
                ),
        );

        $this->table(['ID', 'Name', 'Closed'], collect($boards)
            ->map(fn(Board $board) => [$board->id, $board->name, $board->closed])
            ->toArray()
        );
    }
}
