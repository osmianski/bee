<?php

namespace Osmianski\Reflection;

use Osmianski\ComposerLock\ComposerLock;
use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Helper\Object_;

/**
 * @property Class_[] $classes
 */
class Reflection extends Object_
{
    protected ComposerLock $composer_lock;

    protected function get_classes(): array
    {
        $classes = [];

        foreach ($this->composer_lock->packages as $package) {
            foreach ($package->autoload->{'psr-4'} as $namespace => $path) {
                $this->loadClasses($classes, $namespace, $path);
            }
        }
    }

    protected function loadClasses(array  &$classes, string $namespace,
        string $path): void
    {
        throw new NotImplemented();
    }
}
