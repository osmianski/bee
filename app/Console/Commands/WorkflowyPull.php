<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WorkflowyPull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workflowy:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Workflowy data to the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
