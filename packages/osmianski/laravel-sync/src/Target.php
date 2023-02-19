<?php

namespace Osmianski\Sync;

use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;

/**
 * @property Source $source
 */
abstract class Target extends SuperObject
{
    protected function get_source(): Source {
        throw new Required(__METHOD__);
    }

    abstract public function sync(): void;
}
