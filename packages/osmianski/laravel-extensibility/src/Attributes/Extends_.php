<?php

namespace Osmianski\Extensibility\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class Extends_
{
    public function __construct(public string $className)
    {
    }
}
