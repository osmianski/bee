<?php

namespace Osmianski\Sync;

class Service
{
    public function from(array $from): Builder
    {
        return new Builder(['from' => $from]);
    }
}
