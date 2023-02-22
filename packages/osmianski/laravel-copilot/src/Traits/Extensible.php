<?php

namespace Osmianski\Copilot\Traits;

trait Extensible
{
    public static function new(...$args): static {
        $class = 'Copilot\\' . static::class;
        return new $class(...$args);
    }
}
