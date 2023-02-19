<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class WorkflowyConnect extends Command
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
    protected $description = 'Configure Workflowy connection';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Enter your Workflowy credentials');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $this->writeNewEnvironmentFileWith([
            'WORKFLOWY_EMAIL' => $email,
            'WORKFLOWY_PASSWORD' => Crypt::encrypt($password),
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
