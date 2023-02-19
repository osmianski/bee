<?php

namespace Osmianski\Sync\Source;

use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\Sync\Source;

/**
 * @property array $items
 */
class Array_ extends Source
{
    protected function get_items(): array {
        throw new Required(__METHOD__);
    }

}
