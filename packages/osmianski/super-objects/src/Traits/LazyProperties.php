<?php

declare(strict_types=1);

namespace Osmianski\SuperObjects\Traits;

use Osmianski\SuperObjects\Exceptions\Required;

trait LazyProperties
{
    public function __get(string $property): mixed {
        return $this->$property = $this->default($property);
    }

    public function __isset(string $property): bool {
        try {
            return $this->__get($property) !== null;
        }
        /** @noinspection PhpRedundantCatchClauseInspection */
        catch (Required) {
            return false;
        }
    }
    protected function default(string $property): mixed {
        $method = "get_{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }
}
