<?php

use Orchestra\Testbench\TestCase;
use Osmianski\Workflowy\Workflowy;

class ConnectionTest extends TestCase
{
    public function test_that_workflowy_package_is_registered()
    {
        $this->assertTrue(Workflowy::test());
    }

}
