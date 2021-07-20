<?php

namespace Erupt\Traits;

use Erupt\Models\PropertyFlags\BasePropertyFlagList as PropertyFlagList;
use Erupt\Models\PropertyFlags\BasePropertyFlag as Flag;

trait HasPropertyFlagList
{
    protected PropertyFlagList $flags;

    public function setPropertyFlags(PropertyFlagList $flags): void
    {
        $this->flags = $flags;
    }

    public function getPropertyFlags(): PropertyFlagList
    {
        return $this->flags;
    }

    public function updatePropertyFlags(Flag $flag): void
    {
        $this->flags->add($flag);
    }

    public function checkFlag(string $flagName): bool
    {
        foreach($this->flags as $flag) {
            if($flag->check($flagName)) {
                return true;
            }
        }
        return false;
    }
}