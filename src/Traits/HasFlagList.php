<?php

namespace Erupt\Traits;

use Erupt\Flags\Lists\FlagList;

trait HasFlagList
{
    protected FlagList $flags;

    public function initFlagList(): void
    {
        $this->flags = new FlagList;
    }

    public function getFlagList(): FlagList
    {
        return $this->flags;
    }
}