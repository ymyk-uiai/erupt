<?php

namespace Erupt\Abstracts\Relationships\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Abstracts\Relationships\Members\Member;
use Erupt\Abstracts\Relationships\Relationships\Relationship;

abstract class UniformRelationship extends Relationship
{
    protected Member $sbj;

    public function getSbj()
    {
        return $this->sb;
    }

    public function setSbj(Member $sbj)
    {
        $this->sbj = $sbj;
    }

    public function relateTo($modelName)
    {
        if($this->sbj->getName() === $modelName) {
            return true;
        } else if($this->obj->getName() === $modelName) {
            return true;
        } else {
            return false;
        }

        //  return $this->sbj->checkName($name) || $this->obj->checkName($name) || false;
    }

    public function serve($context)
    {
        if($this->sb->getName() === $context) {
            return $this->ob->getName();
        } else if($this->ob->getName() === $context) {
            return $this->sb->getName();
        }
    }
}