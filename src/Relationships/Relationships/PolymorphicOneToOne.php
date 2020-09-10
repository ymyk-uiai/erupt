<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Relationships\Constructors\Relationships\PolymorphicOneToOneConstructor as Constructor;
use Erupt\Relationships\Relationships\UniformOneToOne;
use Erupt\Abstracts\Relationships\Relationships\PolymorphicRelationship;

class PolymorphicOneToOne extends PolymorphicRelationship
{
    public function __construct()
    {
        //
    }

    public static function build($sb, $ob, $polyIndex)
    {
        return Constructor::build($sb, $ob, $polyIndex);
    }

    public function tryUni()
    {
        if(count($this->sbjs) < 2) {
            return UniformOneToMany::build($this->sbjs[0], $this->obj, $this->morphIndex);
        } else {
            return false;
        }
    }
}