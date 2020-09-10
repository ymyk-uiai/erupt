<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Abstracts\Relationships\Relationships\UniformRelationship;
use Erupt\Relationships\Constructors\Relationships\UniformOneToOneConstructor as Constructor;
use Erupt\Relationships\Relationships\PolymorphicOneToOne;

class UniformOneToOne extends UniformRelationship
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
            return PolyMorphicOneToOne::build($this->sbj, $this->obj, $this->morphIndex);
        } else {
            return false;
        }
    }

    public function tryGettingPlan($name)
    {
        $sbName = $this->sbj->getName();

        if($this->obj->getName() === $name) {
            return "foreignId:${sbName}_id";
        }
    }
}