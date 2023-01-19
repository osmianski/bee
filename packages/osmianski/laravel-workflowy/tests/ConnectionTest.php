<?php

namespace Osmianski\Workflowy\Tests;

use Orchestra\Testbench\TestCase;
use Osmianski\Workflowy\Facades\Workflowy;
use Osmianski\Workflowy\WorkflowyServiceProvider;

class ConnectionTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            WorkflowyServiceProvider::class,
        ];
    }

    public function test_that_it_connects_to_workflowy()
    {
        $raw = Workflowy::getWorkspace()->raw;
        $this->assertNotNull($raw);
    }

}
