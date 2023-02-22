<?php

namespace Osmianski\Helper\Traits;

trait ConstructedFromArray
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
