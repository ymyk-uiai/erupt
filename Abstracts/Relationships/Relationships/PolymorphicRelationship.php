<?php

namespace Erupt\Abstracts\Relationships\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Abstracts\Relationships\Members\Member;

abstract class PolymorphicRelationship extends BaseListItem
{
    protected $sbs = [];

    protected $ob;

    protected $morphIndex;

    public function __construct(Member $sb, Member $ob, $morphIndex)
    {
        $this->sbs[] = $sb;

        $this->ob = $ob;

        $this->morphIndex = $morphIndex;
    }

    public function getSubjects()
    {
        return $this->sbs;
    }

    public function getObject()
    {
        return $this->ob;
    }

    public function getMorphIndex()
    {
        return $this->morphIndex;
    }

    public function tryMerge(Polymorphic $relationship)
    {
        if($this->morphIndex === $relationship->getMorphIndex()) {
            foreach($relationship->getSubjects() as $sb) {
                $this->sbs[] = $sb;
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