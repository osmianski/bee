<?php

namespace App\Console\Commands;

use App\Trello\Trello;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Osmianski\Helper\EnvironmentFileEditor;

class TrelloConnect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:connect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect to Trello';

    /**
     * Execute the console command.
     */
    public function handle(EnvironmentFileEditor $env): void
    {
        $this->line('1. Select your integration (or create a new one) on https://trello.com/power-ups/admin');
        $apiKey = $this->ask('Paste the integration\'s API key -> API key field');

        $this->line('2. Manually generate a token using a link near the API key.');
        $token = Crypt::encrypt($this->secret('Paste the generated token'));

        $trello = new Trello();
        $trello->setCredentials($apiKey, $token);
        $trello->getBoards();

        $this->info('Successfully connected to Trello!');

        $env->edit([
            'TRELLO_API_KEY' => $apiKey,
            'TRELLO_TOKEN' => $token,
        ]);
    }
}
