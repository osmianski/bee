<?php

namespace Osmianski\ComposerLock;

use Illuminate\Support\Collection;
use Osmianski\Helper\Object_;

/**
 * @property string $path
 * @property \stdClass $raw
 * @property Collection|Package[] $packages
 * @property string $root_package_name
 * @property Package $root_package
 */
class ComposerLock extends Object_
{
    protected function get_path(): string
    {
        return base_path();
    }

    protected function get_raw(): \stdClass
    {
        return json_decode(file_get_contents("{$this->path}/composer.lock"));
    }

    protected function get_packages(): Collection
    {
        return collect($this->raw->packages)->keyBy('name');
    }

    protected function get_root_package_name(): string
    {
        $json = json_decode(file_get_contents("{$this->path}/composer.json"));

        return $json->name;
    }

    protected function get_root_package(): \stdClass|Package
    {
        return $this->packages[$this->root_package_name];
    }
}
