<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Relationships\Constructors\Relationships\PolymorphicOneToManyConstructor as Constructor;
use Erupt\Relationships\Relationships\UniformOneToMany;
use Erupt\Abstracts\Relationships\Relationships\PolymorphicRelationship;
use Erupt\Models\Constructors\Relationships\Relationship as ModelRelationship;

class PolymorphicOneToMany extends PolymorphicRelationship
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

    public function tryGettingPlan($name)
    {
        if($this->obj->getName() === $name) {
            return "morphs:${name}able";
        }
    }
    
    public function getModelRelationships($model, $relationships)
    {
        $check = false;

        foreach($this->sbjs as $sbj) {
            if($sbj->getName() == $model->getName()) {
                $check = true;
            }
        }

        if($check) {
            $i = $this->obj;
            $relationships->add(ModelRelationship::build($i));
        } else if($this->obj->getName() == $model->getName()) {
            $is = $this->sbjs;
            foreach($is as $i) {
                $relationships->add(ModelRelationship::build($i));
            }
        }
    }
}