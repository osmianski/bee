<?php

namespace Osmianski\Sync\Target;

use Illuminate\Support\Facades\DB;
use Osmianski\SuperObjects\Exceptions\NotImplemented;
use Osmianski\SuperObjects\Exceptions\Required;
use Osmianski\Sync\Target;

/**
 * @property string $class_name
 */
class Model extends Target
{
    protected function get_class_name(): string {
        throw new Required(__METHOD__);
    }

    public function sync(): void
    {
        DB::transaction(function() {
            $this->markAllModelsAsDeleted();
            $this->insertUpdateChangesAndUnmarkDeletions();
            $this->purgeDeletions();
        });
    }

    protected function markAllModelsAsDeleted(): void
    {
        throw new NotImplemented();
    }

    protected function insertUpdateChangesAndUnmarkDeletions(): void
    {
        throw new NotImplemented();
    }

    protected function purgeDeletions(): void
    {
        throw new NotImplemented();
    }
}
