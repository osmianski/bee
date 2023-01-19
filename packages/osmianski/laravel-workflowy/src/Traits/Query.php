<?php

namespace Osmianski\Workflowy\Traits;


use Illuminate\Support\Collection;

trait Query
{
    /**
     * @return Collection|Node[]
     */
    public function query(): Collection|array
    {
        return collect($this->doQuery($this->children));
    }

    /**
     * @return Node[]
     */
    protected function doQuery(Collection|array $children,
        array $parents = []): array
    {
        $result = [];

        foreach ($children as $node) {
            $result[] = $entry = clone $node;
            $entry->parents = $parents;

            $result = array_merge($result,
                $this->doQuery($node->children, array_merge($parents, [$entry])));
        }

        return $result;
    }
}
