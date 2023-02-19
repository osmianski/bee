<?php

namespace Osmianski\Sync;

use Osmianski\SuperObjects\Exceptions\NotImplemented;
use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;

/**
 * @property array $from
 * @property string $to
 */
class Builder extends SuperObject
{
    protected function get_from(): array {
        throw new Required(__METHOD__);
    }

    protected function get_to(): string {
        throw new Required(__METHOD__);
    }

    public function to(string $to): static {
        $this->to = $to;

        return $this;
    }

    public function now(): void {
        $this->build()->sync();
    }

    public function build(): Target
    {
        return new Target\Model([
            'source' => new Source\Array_([
                'items' => $this->from,
            ]),
            'class_name' => $this->to,
        ]);
    }
}
