<?php

namespace Erupt\Plans\Attributes;

use Erupt\Foundations\BaseContainer;
use Erupt\Plans\Attributes\BaseAttributeContainer;

abstract class BaseAttributeContainer extends BaseContainer
{
    abstract protected function makeCorrespondingList(): BaseAttributeList;

    public function pack(BaseAttributeContainer $container): Self
    {
        foreach($container as $list) {
            if($list->isCommand()) {
                $corList = $this->makeCorrespondingList();
                $corList->takeOver($list);
                $this->add($corList);
            } else {
                foreach($this as $thList) {
                    $thList->add($list);
                }
            }
        }

        return $this;
    }

    public function add(BaseAttributeList|Self $attribute): void
    {
        parent::addListOrContainer($attribute);
    }

    public function remove(BaseAttributeList|Self $attribute): void
    {
        parent::removeListOrContainer($attribute);
    }
}