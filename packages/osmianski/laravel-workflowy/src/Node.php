<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Carbon;
use Osmianski\Workflowy\Node\Layout;

class Node
{
    public Workspace $workspace;
    public ?Node $parent;
    public int $depth;
    public int $position;
    public string $id;
    public ?string $name;
    public ?string $note;
    public ?Layout $layout;
    /**
     * @var array|Node[]
     */
    public array $children;

    public Carbon $created_at;
    public Carbon $updated_at;
}
