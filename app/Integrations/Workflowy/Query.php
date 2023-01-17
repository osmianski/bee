<?php

namespace App\Integrations\Workflowy;

use App\Exceptions\NotImplemented;

class Query
{
    protected Data $data;
    protected array $nodes;

    public function __construct(Data $data, array $nodes)
    {
        $this->data = $data;
        $this->nodes = $nodes;
    }

    public function each(callable $callback): static
    {
        foreach ($this->nodes as $node) {
            $callback(new static($this->data, [$node]));
        }

        return $this;
    }

    public function where(callable $callback): static
    {
        $nodes = [];

        foreach ($this->nodes as $node) {
            if ($callback(new static($this->data, [$node]))) {
                $nodes[] = $node;
            }
        }

        return new static($this->data, $nodes);
    }

    public function value(callable $callback): mixed
    {
        $node = empty($this->nodes)
            ? null
            : $this->data->original($this->nodes[0]);

        return $callback($node);
    }

    public function layout(): ?string
    {
        return $this->value(
            fn(?\stdClass $node) => $node->metadata->layoutMode ?? null);
    }

    public function todo(): bool
    {
        return $this->layout() === 'todo';
    }

    public function whereTodo(): static
    {
        return $this->where(fn(Query $node) => $node->todo());
    }

    public function original(): ?bool {
        return $this->value(
            fn(?\stdClass $node) => $node === $this->data->original($node));
    }

    public function whereOriginal(): static
    {
        return $this->where(fn(Query $node) => $node->original());
    }

    public function name(): ?string
    {
        return $this->value(fn(?\stdClass $node) => $node->nm ?? null);
    }

    public function whereRegex(string $pattern): static
    {
        return $this->where(
            fn(Query $node) => preg_match($pattern, $node->name()));
    }

    public function note(): ?string
    {
        return $this->value(fn(?\stdClass $node) => $node->no ?? null);
    }

    public function children(): static
    {
        return new static($this->data,
            $this->value(fn(?\stdClass $node) => $node->ch ?? []));
    }

    public function id(): ?string
    {
        return empty($this->nodes) ? null : $this->nodes[0]->id;
    }

    public function originalId(): ?string
    {
        return $this->value(fn(?\stdClass $node) => $node->id ?? null);
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

    public function data(): ?\stdClass
    {
        return $this->value(function(?\stdClass $node) {
            if (!$node) {
                return null;
            }

            $node = clone $node;
            unset($node->ch);

            return $node;
        });
    }

    public function completed(): bool
    {
        return $this->value(fn(?\stdClass $node) => isset($node->cp));
    }

    public function completedAt(): ?DateTime {
        return $this->value(function(?\stdClass $node) {
            if (!isset($node->cp)) {
                return null;
            }

            // TODO: continue here
            $timestamp = $node->cp + $this->data;
        });
    }
}
