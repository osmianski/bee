<?php

namespace App\Console\Commands;

use App\Trello\Board;
use App\Trello\Card;
use App\Trello\Trello;
use App\Trello\Workspace;
use Illuminate\Console\Command;
use Osmianski\Helper\Exceptions\NotImplemented;

class TrelloRemind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:remind {id : Board or workspace ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In a given board or workspace, set a reminder 5 minutes before a card is due';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $trello = new Trello();
        $id = $this->argument('id');

        if ($workspace = $trello->getWorkspaces()[$id] ?? null) {
            $this->handleWorkspace($workspace);
            return static::SUCCESS;
        }

        if ($board = $trello->getBoards(open: true)[$id] ?? null) {
            $this->handleBoard($board);
            return static::SUCCESS;
        }

        $this->error("Workspace or board with ID '{$id}' not found.");
        return static::FAILURE;
    }

    protected function handleWorkspace(Workspace $workspace): void
    {
        foreach ($workspace->getBoards(open: true) as $board) {
            $this->handleBoard($board);
        }
    }

    protected function handleBoard(Board $board): void
    {
        foreach ($board->getCards(open: true) as $card) {
            if ($card->due && !$card->reminder) {
                $this->handleCard($card);
            }
        }
    }

    protected function handleCard(Card $card): void
    {
        $card->update(['reminder' => 5]);
    }
}
