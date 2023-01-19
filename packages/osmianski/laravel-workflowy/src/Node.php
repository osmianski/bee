<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Collection;
use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;

/**
 * @property Workspace $workspace
 * @property \stdClass $raw
 * @property Node[]|Collection $children
 */
class Node extends SuperObject
{
    protected function get_workspace(): Workspace {
        throw new Required(__METHOD__);
    }

    protected function get_raw(): \stdClass {
        throw new Required(__METHOD__);
    }

    protected function get_children(): Collection {
        return collect($this->raw->ch ?? [])
            ->map(fn(\stdClass $raw) => new Node([
                'workspace' => $this,
                'raw' => $raw,
            ]));
    }
}
