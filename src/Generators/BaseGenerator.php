<?php

namespace Erupt\Generators;

use Erupt\Foundation\BaseListItem;

abstract class BaseGenerator extends BaseListItem
{
    protected bool $file = false;

    protected bool $migration = false;

    public function isFile(): bool
    {
        return $this->file;
    }

    public function isMigration(): bool
    {
        return $this->migration;
    }

    public function isTarget($subject): bool
    {
        foreach($this->targets as $target) {
            if($subject instanceof $target) {
                return true;
            }
        }
        return false;
    }
}