<?php

namespace Erupt\Models\SchemaMethods;

use Erupt\Foundations\Lists\BaseListContainer;

abstract class BaseSchemaMethodContainer extends BaseListContainer
{
    public function add($attribute)
    {
        parent::add($attribute);
    }
}