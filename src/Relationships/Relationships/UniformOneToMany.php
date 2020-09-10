<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Abstracts\Relationships\Relationships\UniformRelationship;
use Erupt\Relationships\Constructors\Relationships\UniformOneToManyConstructor as Constructor;
use Erupt\Relationships\Relationships\PolymorphicOneToMany;
use Erupt\Models\Constructors\Relationships\Relationship as ModelRelationship;

class UniformOneToMany extends UniformRelationship
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
            return PolymorphicOneToMany::build($this->sbj, $this->obj, $this->morphIndex);
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

    public function getModelRelationships($model, $relationships)
    {
        if($this->sbj->getName() == $model->getName()) {
            $i = $this->obj;
        } else if($this->obj->getName() == $model->getName()) {
            $i = $this->sbj;
        } else {
            return false;
        }
        
        $relationships->add(ModelRelationship::build($i));
    }
}