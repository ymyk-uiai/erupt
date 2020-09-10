<?php

namespace Erupt\Plans\Lists\Attributes;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Plans\Constructors\Lists\Attributes\AttributeListConstructor;

class AttributeList extends BaseList
{
    public function __construct()
    {
        //
    }

    public static function build($plan): AttributeList
    {
        return AttributeListConstructor::build($plan);
    }

    public function add($attribute)
    {
        parent::add($attribute);
    }
}