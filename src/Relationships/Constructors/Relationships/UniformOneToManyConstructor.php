<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\UniformOneToMany;

class UniformOneToManyConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new UniformOneToMany;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}