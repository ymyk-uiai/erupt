<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Abstracts\Relationships\Relationships\UniformRelationship;
use Erupt\Relationships\Constructors\Relationships\UniformManyToManyConstructor as Constructor;
use Erupt\Relationships\Relationships\PolymorphicOneToMany;

class UniformManyToMany extends UniformRelationship
{
    public function __construct()
    {
        //
    }
    
    public static function build($sb, $ob, $polyIndex)
    {
        return Constructor::build($sb, $ob, $polyIndex);
    }

    public function tryMorph()
    {
        if($this->morphIndex > -1) {
            return new PolymorphicManyToMany($this->sbj, $this->obj, $this->morphIndex);
        } else {
            return false;
        }
    }

    public function tryGettingPlan($name)
    {
        return false;
    }
}