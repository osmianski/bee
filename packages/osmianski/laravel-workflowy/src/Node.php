<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Collection;
use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\SuperObjects\SuperObject;
use Osmianski\Workflowy\Enums\Layout;

/**
 * @property Workspace $workspace
 * @property \stdClass $raw
 * @property string $id
 * @property ?string $name
 * @property ?string $note
 * @property ?Layout $layout
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

    protected function get_id(): string {
        return $this->raw->id;
    }

    protected function get_name(): ?string {
        return $this->raw->nm ?? null;
    }

    protected function get_note(): ?string {
        return $this->raw->no ?? null;
    }

    protected function get_layout(): ?Layout {
        if (!($layout = ($this->raw->metadata->layoutMode ?? null))) {
            return null;
        }

        return Layout::tryFrom($layout);
    }

    protected function get_children(): Collection {
        return collect($this->raw->ch ?? [])
            ->map(fn(\stdClass $raw) => new Node([
                'workspace' => $this,
                'raw' => $raw,
            ]));
    }
}
