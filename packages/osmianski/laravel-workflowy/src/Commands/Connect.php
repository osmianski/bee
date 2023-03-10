<?php

namespace Osmianski\Workflowy\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Osmianski\Helper\EnvironmentFileEditor;
use Osmianski\Workflowy\Exceptions\InvalidCredentials;
use Osmianski\Workflowy\Workflowy;

class Connect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workflowy:connect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure and test Workflowy connection';

    /**
     * Execute the console command.
     */
    public function handle(EnvironmentFileEditor $env): void
    {
        $this->line('Enter your Workflowy credentials');
        $username = $this->ask('Username');
        $password = Crypt::encrypt($this->secret('Password'));

        $workflowy = new Workflowy();
        $workflowy->setCredentials($username, $password);

        try {
            $workflowy->connect();
        }
        catch (InvalidCredentials $e) {
            $this->error($e->getMessage());
        }

        $this->info('Successfully connected to Workflowy!');

        $env->edit([
            'WORKFLOWY_USERNAME' => $username,
            'WORKFLOWY_PASSWORD' => $password,
        ]);
    }
}
