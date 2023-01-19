<?php

namespace Osmianski\SuperObjects;

use Osmianski\SuperObjects\Traits\LazyProperties;

class SuperObject
{
    use LazyProperties;

    public function __construct(array $data = []) {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}
