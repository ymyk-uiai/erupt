<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\UniformOneToOne;

class UniformOneToOneConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new UniformOneToOne;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}