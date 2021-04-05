<?php

namespace Erupt\Models\SchemaMethods;

use Erupt\Foundations\Lists\BaseList;

abstract class BaseSchemaMethodList extends BaseList
{
    //  Unit Type BaseProperty|BasePropertyList
    public function add($property)
    {
        parent::add($property);
    }

    public function remove($property)
    {
        parent::remove($property);
    }
}