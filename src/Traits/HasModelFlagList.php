<?php

namespace Erupt\Traits;

use Erupt\Models\ModelFlags\BaseModelFlagList as ModelFlagList;
use Erupt\Models\ModelFlags\BaseModelFlag as Flag;

trait HasModelFlagList
{
    protected ModelFlagList $flags;

    public function setModelFlags(ModelFlagList $flags): void
    {
        $this->flags = $flags;
    }

    public function getModelFlags(): ModelFlagList
    {
        return $this->flags;
    }

    public function updateModelFlags(Flag $flag): void
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