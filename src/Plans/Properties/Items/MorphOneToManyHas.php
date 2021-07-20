<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\MorphOneToManyHas as CorrespondingContainer;

class MorphOneToManyHas extends BaseProperty
{
    protected string $sbs;

    protected string $ob;

    public function __construct(AttributeList $attributes, string $sbs, string $ob)
    {
        $this->sbs = $sbs;
        $this->ob = $ob;

        parent::__construct($attributes);
    }

    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}