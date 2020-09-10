<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\PolymorphicOneToMany;

class PolymorphicOneToManyConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new PolymorphicOneToMany;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}