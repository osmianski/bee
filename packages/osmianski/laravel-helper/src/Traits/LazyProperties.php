<?php

declare(strict_types=1);

namespace Osmianski\Helper\Traits;

trait LazyProperties
{
    public function __get(string $property): mixed {
        return $this->$property = $this->{"get_{$property}"}();
    }

    public function __isset(string $property): bool {
        return $this->__get($property) !== null;
    }
}
