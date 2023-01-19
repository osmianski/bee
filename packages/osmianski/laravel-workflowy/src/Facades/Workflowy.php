<?php

namespace Osmianski\Workflowy\Facades;

use Illuminate\Support\Facades\Facade;

class Workflowy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'workflowy';
    }
}
