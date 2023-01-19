<?php

namespace Osmianski\Workflowy;

use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;

/**
 * @property \stdClass $raw
 */
class Workspace extends SuperObject
{
    protected function get_raw(): \stdClass {
        throw new Required(__METHOD__);
    }
}
