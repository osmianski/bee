<?php

namespace Osmianski\Sync\Facades;

use Illuminate\Support\Facades\Facade;

class Sync extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Osmianski\Sync\Service::class;
    }
}
{

}
