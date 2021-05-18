<?php

namespace Erupt\Plans\Methods\Lists;

use Erupt\Plans\Methods\BaseUpdaterList;

class UpdaterList extends BaseUpdaterList
{
    public function setRelationship($bool): void
    {
        $this->relationship = $bool;
    }

    public function getRelationship(): bool
    {
        return $this->relationship;
    }
}