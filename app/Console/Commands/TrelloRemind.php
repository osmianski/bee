<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TrelloRemind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In a given board, set a reminder 5 minutes before a card is due';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
