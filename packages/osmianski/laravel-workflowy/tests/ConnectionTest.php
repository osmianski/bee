<?php

namespace Osmianski\Workflowy\Tests;

use Orchestra\Testbench\TestCase;
use Osmianski\Workflowy\Enums\Layout;
use Osmianski\Workflowy\Facades\Workflowy;
use Osmianski\Workflowy\Node;
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
        $this->assertNotNull(Workflowy::getWorkspace()->raw);
    }

    public function test_workspace_api()
    {
        $workspace = Workflowy::getWorkspace();

        $this->assertCount(1, $workspace->children);
        $this->assertInstanceOf(Node::class, $workspace->children[0]);
    }

    public function test_node_api()
    {
        $node = Workflowy::getWorkspace()->children[0];

        $this->assertCount(10, $node->children);
        $this->assertInstanceOf(Node::class, $node->children[0]);
        $this->assertEquals('<b>How to get started</b>', $node->children[1]->name);
        $this->assertEquals(Layout::P, $node->children[1]->layout);
    }
}
