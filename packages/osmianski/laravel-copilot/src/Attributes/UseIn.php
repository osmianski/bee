<?php

namespace Osmianski\Copilot\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class UseIn
{
    public function __construct(public string $className)
    {
    }
}
