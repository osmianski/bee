<?php

namespace App\Console\Commands;

use App\Trello\Trello;
use Illuminate\Console\Command;

class TrelloGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:get {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue GET request to your Trello';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $trello = new Trello();

        $response = $trello->get($this->argument('path'));

        echo json_encode($response->object(), JSON_PRETTY_PRINT);
    }
}
