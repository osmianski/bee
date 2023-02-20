<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\ServiceProvider;
use Osmianski\Workflowy\Commands;

class WorkflowyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Connect::class,
            ]);
        }
    }
}
