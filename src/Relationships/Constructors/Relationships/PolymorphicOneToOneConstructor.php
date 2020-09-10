<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\PolymorphicOneToOne;

class PolymorphicOneToOneConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new PolymorphicOneToOne;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}