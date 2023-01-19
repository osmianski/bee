<?php

namespace Osmianski\Workflowy\Tests;

use Orchestra\Testbench\TestCase;
use Osmianski\SuperObjects\Traits\LazyProperties;
use Osmianski\Workflowy\Enums\Layout;
use Osmianski\Workflowy\Facades\Workflowy;
use Osmianski\Workflowy\Node;
use Osmianski\Workflowy\WorkflowyServiceProvider;
use Osmianski\Workflowy\Workspace;

/**
 * @property Workspace $workspace
 */
class ConnectionTest extends TestCase
{
    use LazyProperties;
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

    protected function get_workspace(): Workspace {
        return Workflowy::getWorkspace();
    }

    public function test_that_it_connects_to_workflowy()
    {
        $this->assertNotNull($this->workspace->raw);
    }

    public function test_workspace_api()
    {
        $workspace = $this->workspace;

        $this->assertCount(1, $workspace->children);
        $this->assertInstanceOf(Node::class, $workspace->children[0]);
    }

    public function test_node_api()
    {
        $node = $this->workspace->children[0];

        $this->assertCount(10, $node->children);
        $this->assertInstanceOf(Node::class, $node->children[0]);
        $this->assertEquals('<b>How to get started</b>', $node->children[1]->name);
        $this->assertEquals(Layout::P, $node->children[1]->layout);
    }

    public function test_query_api() {
        $query = $this->workspace->query();
        $this->assertCount(13, $query);

    }
}
