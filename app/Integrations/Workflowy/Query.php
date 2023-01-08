<?php

namespace App\Integrations\Workflowy;

class Query
{
    protected Data $data;
    protected array $nodes;

    public function __construct(Data $data, array $nodes)
    {
        $this->data = $data;
        $this->nodes = $nodes;
    }

    public function whereName(string $pattern): static
    {
        $nodes = [];

        foreach ($this->nodes as $node) {
            if (preg_match($pattern, $this->data->original($node)->nm)) {
                $nodes[] = $node;
            }
        }

        return new static($this->data, $nodes);
    }

    public function children(): static
    {
        if (empty($this->nodes)) {
            return new Query($this->data, []);
        }

        return new static($this->data, $this->nodes[0]->ch ?? []);
    }

    public function whereTodo(): static
    {
        $nodes = [];

        foreach ($this->nodes as $node) {
            if (($this->data->original($node)->metadata->layoutMode ?? null) == 'todo') {
                $nodes[] = $node;
            }
        }

        return new static($this->data, $nodes);
    }

    public function each(callable $callback): static
    {
        foreach ($this->nodes as $node) {
            $callback(new static($this->data, [$node]));
        }

        return $this;
    }

    public function id(): string
    {
        if (empty($this->nodes)) {
            return '';
        }

        return $this->nodes[0]->id;
    }

    public function name(): string
    {
        if (empty($this->nodes)) {
            return '';
        }

        return $this->data->original($this->nodes[0])->nm;
    }

    public function internalLink(string $title = null): string
    {
        $id = $this->id();
        if (($pos = strrpos($id, '-')) !== false) {
            $id = substr($id, $pos + 1);
        }

        if (!$title) {
            $title = $this->name();
        }

        return "<a href=\"https://workflowy.com/#/{$id}\">{$title}</a>";
    }
}
