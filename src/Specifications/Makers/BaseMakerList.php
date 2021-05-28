<?php

namespace Erupt\Specifications\Makers;

use Erupt\Foundations\BaseList;
use Erupt\Interfaces\Makers\BaseMaker;

abstract class BaseMakerList extends BaseList
{
    //  Unit Type BaseMaker|BaseMakerList
    public function add($maker)
    {
        parent::addItemOrList($maker);
    }
}