<?php

namespace Osmianski\Extensibility\Samples;

use Osmianski\Extensibility\Traits\Extensible;

class Foo
{
    use Extensible;

    public function greet(): string
    {
        return 'Hello, world!';
    }
}
