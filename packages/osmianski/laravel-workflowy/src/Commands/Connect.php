<?php

namespace Osmianski\Workflowy\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
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
    public function handle(): void
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

        $this->writeNewEnvironmentFileWith([
            'WORKFLOWY_USERNAME' => $username,
            'WORKFLOWY_PASSWORD' => $password,
        ]);
    }

    protected function writeNewEnvironmentFileWith(array $variables): void
    {
        $contents = file_get_contents($this->laravel->environmentFilePath());

        foreach ($variables as $variable => $value) {
            $this->setVariable($contents, $variable, $value);
        }

        file_put_contents($this->laravel->environmentFilePath(), $contents);
    }

    protected function setVariable(string &$contents, string $variable,
        string $value): void
    {
        $replaced = preg_replace(
            "/^" . preg_quote($variable) . "=.*$/m",
            "{$variable}={$value}",
            $contents
        );

        if ($contents !== $replaced) {
            $contents = $replaced;
        }
        else {
            $contents .= "\n{$variable}={$value}";
        }
    }
}
