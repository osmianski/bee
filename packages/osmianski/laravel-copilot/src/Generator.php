<?php

namespace Osmianski\Copilot;

use Osmianski\Helper\Traits\ConstructedFromArray;

abstract class Generator
{
    use ConstructedFromArray;

    protected Generated\Code $code;

    public function __construct()
    {
    }

    abstract public function generate(): void;
}
