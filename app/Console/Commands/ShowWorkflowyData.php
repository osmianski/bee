<?php

namespace App\Console\Commands;

use App\Integrations\Workflowy;
use Illuminate\Console\Command;

class ShowWorkflowyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workflowy:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Outputs Workflowy data as JSON';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $workflowy = new Workflowy();
        $this->output->writeln(json_encode($workflowy->data(), JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
