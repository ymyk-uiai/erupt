<?php

namespace Erupt\Abstracts\Relationships\Relationships;

use Erupt\Abstracts\Relationships\Members\Member;
use Erupt\Abstracts\Relationships\Relationships\Relationship;

abstract class PolymorphicRelationship extends Relationship
{
    protected $sbjs = [];

    public function getSbjs()
    {
        return $this->sbjs;
    }

    public function setSbj(Member $sbj)
    {
        $this->sbjs[] = $sbj;
    }

    public function tryMerge(PolymorphicRelationship $relationship)
    {
        if($this->morphIndex === $relationship->getMorphIndex()) {
            foreach($relationship->getSbjs() as $sbj) {
                $this->sbjs[] = $sbj;
            }
            return true;
        }

        return false;
    }

    public function sbsInclude($modelName)
    {
        foreach($this->sbs as $sb) {
            if($sb->getName() === $modelName) {
                return true;
            }
        }

        return false;
    }

    public function relateTo($modelName)
    {
        if($this->sbsInclude($modelName)) {
            return true;
        } else if($this->ob->getName() === $modelName) {
            return true;
        } else {
            return false;
        }
    }

    public function serve($context)
    {
        if($this->sbsInclude($context)) {
            return $this->ob->getName();
        } else if($this->ob->getName() === $context) {
            return $this->ob->getName()."able";
        }
    }
}