<?php

namespace App\Integrations\Workflowy;

use App\Exceptions\NotImplemented;

class Parser
{
    protected bool $extractFirstDateTime;
    protected bool $extractTags;
    protected bool $parsed = false;
    protected ?string $name;
    protected ?string $note;
    protected ?\DateTime $firstDatetime = null;
    protected array $tags = [];

    public function __construct(Query $query,
        bool  $extractFirstDateTime = false, bool $extractTags = false)
    {
        $this->name = $query->name();
        $this->note = $query->note();

        $this->extractFirstDateTime = $extractFirstDateTime;
        $this->extractTags = $extractTags;
    }

    public function name(): ?string {
        $this->parse();
        return $this->name;
    }

    public function note(): ?string {
        $this->parse();
        return $this->note;
    }

    public function firstDateTime(): ?\DateTime {
        $this->parse();
        return $this->firstDatetime;
    }

    public function tags(): array {
        $this->parse();
        return $this->tags;
    }

    protected function parse(): void
    {
        if ($this->parsed) {
            return;
        }

        $this->name = $this->parseString($this->name);
        $this->note = $this->parseString($this->note);

        $this->parsed = true;
    }

    protected function parseString(?string $string): ?string
    {
        if (!$string) {
            return null;
        }

        $string = preg_replace_callback('/<time\s*[^>]*>/u',
            fn($match) => $this->parseDatetime($match), $string);
        $string = preg_replace_callback('/#[A-Za-z0-9-_]+\s*/u',
            fn($match) => $this->parseTag($match), $string);

        return $string ?: null;
    }

    protected function parseDatetime(array $match): string
    {
        throw new NotImplemented();
    }

    protected function parseTag(array $match): string
    {
        throw new NotImplemented();
    }
}
