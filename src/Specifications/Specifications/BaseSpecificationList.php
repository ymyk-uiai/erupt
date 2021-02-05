<?php

namespace Erupt\Specifications\Specifications;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Specifications\Specifications\BaseSpecification;

class BaseSpecificationList extends BaseList
{
    //  Unit Type BaseSpecification|BaseSpecificationList
    public function add($specification)
    {
        parent::add($specification);
    }
}