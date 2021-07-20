<?php

namespace Erupt\Plans\Properties\Items;

use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Properties\BaseProperty;
use Erupt\Plans\Attributes\Containers\NormalOneToManyBelongsTo as CorrespondingContainer;

class NormalOneToManyBelongsTo extends BaseProperty
{
    protected string $sb;

    protected string $ob;

    public function __construct(AttributeList $attributes, string $sb, string $ob)
    {
        $this->sb = $sb;
        $this->ob = $ob;

        parent::__construct($attributes);
    }

    public function makeContainer(): CorrespondingContainer
    {
        return new CorrespondingContainer;
    }
}