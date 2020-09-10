<?php

namespace Erupt\Relationships\Constructors\Relationships;

use Erupt\Relationships\Relationships\UniformManyToMany;

class UniformManyToManyConstructor
{
    public static function build($sb, $ob, $polyIndex)
    {
        $obj = new UniformManyToMany;

        $obj->setSbj($sb);

        $obj->setObj($ob);

        $obj->setMorphIndex($polyIndex);

        return $obj;
    }
}