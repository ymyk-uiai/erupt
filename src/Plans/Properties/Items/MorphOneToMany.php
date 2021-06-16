<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\MorphOneToMany as CorrespondingContainer;

class MorphOneToMany extends BaseProperty
{
    public function __construct(AttributeList $attributes, string $models)
    {
        $this->models = $models;

        parent::__construct($attributes);
    }

    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}