<?php

namespace Erupt\Plans\Methods\Containers;

use Erupt\Plans\Methods\BaseUpdaterContainer;

class UpdaterContainer extends BaseUpdaterContainer
{
    public function setRelationship($bool): void
    {
        $this->relationship = $bool;

        foreach($this as $list) {
            $list->setRelationship($bool);
        }
    }

    public function getRelationship(): bool
    {
        return $this->relationship;
    }

    public function count(): int
    {
        return parent::count();
    }
}