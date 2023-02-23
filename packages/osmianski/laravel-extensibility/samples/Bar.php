<?php

namespace Osmianski\Extensibility\Samples;

use Osmianski\Extensibility\Attributes\Extends_;

#[Extends_(Foo::class)]
trait Bar
{
    public function around_greet(callable $proceed): string
    {
        return "{$proceed()} Have a good day!";
    }
}
