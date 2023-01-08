<?php

namespace App\Integrations\Workflowy;

use App\Exceptions\NotImplemented;
use App\Integrations\Workflowy;

class Data
{
    protected \stdClass $data;
    protected ?array $nodesById = null;
    protected Workflowy $connection;

    public function __construct(Workflowy $connection, \stdClass $data)
    {
        $this->data = $data;
        $this->connection = $connection;
    }

    public function topNodes(): array
    {
        return $this->data->projectTreeData->mainProjectTreeInfo->rootProjectChildren;
    }

    public function original(\stdClass $node): \stdClass
    {
        if (!isset($node->metadata->mirror)) {
            return $node;
        }

        if (!isset($node->metadata->mirror->originalId)) {
            // this is the original node of the mirror
            return $node;
        }

        return $this->getById($node->metadata->mirror->originalId);
    }

    protected function getById(string $id): \stdClass
    {
        if ($this->nodesById === null) {
            $this->index($this->topNodes());
        }

        return $this->nodesById[$id];
    }

    protected function index(array $nodes): void
    {
        $this->nodesById = [];

        foreach ($nodes as $node) {
            $this->nodesById[$node->id] = $node;

            if (!empty($node->ch)) {
                $this->index($node->ch);
            }
        }
    }
}
