<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Collection;
use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;
use Osmianski\Workflowy\Traits\Query;

/**
 * @property \stdClass $raw
 * @property Node[]|Collection $children
 */
class Workspace extends SuperObject
{
    use Query;

    protected function get_raw(): \stdClass {
        throw new Required(__METHOD__);
    }

    protected function get_children(): Collection {
        return collect($this->raw->projectTreeData->mainProjectTreeInfo->rootProjectChildren)
            ->map(fn(\stdClass $raw) => new Node([
                'workspace' => $this,
                'raw' => $raw,
            ]));
    }
}
