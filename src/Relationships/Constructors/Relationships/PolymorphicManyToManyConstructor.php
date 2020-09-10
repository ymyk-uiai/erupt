<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\PolymorphicManyToMany;

class PolymorphicManyToManyConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new PolymorphicManyToMany;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}