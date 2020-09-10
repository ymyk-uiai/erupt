<?php

namespace Erupt\Abstracts\Relationships\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;

abstract class Relationship extends BaseListItem
{
    protected Member $ob;

    protected $morphIndex;

    public function getObj()
    {
        return $this->obj;
    }

    public function setObj($obj)
    {
        $this->obj = $obj;
    }

    public function getMorphIndex()
    {
        return $this->morphIndex;
    }

    public function setMorphIndex($morphIndex)
    {
        $this->morphIndex = $morphIndex;
    }
}