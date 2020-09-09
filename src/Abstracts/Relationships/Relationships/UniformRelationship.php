<?php

namespace Erupt\Abstracts\Relationships\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Abstracts\Relationships\Members\Member;

abstract class UniformRelationship extends BaseListItem
{
    protected $sb;

    protected $ob;

    protected $morphIndex;

    public function __construct(Member $sb, Member $ob, $morphIndex)
    {
        $this->sb = $sb;

        $this->ob = $ob;

        $this->morphIndex = $morphIndex;
    }

    public function getSubject()
    {
        return $this->sb;
    }

    public function getObject()
    {
        return $this->ob;
    }

    public function getMorphIndex()
    {
        return $this->morphIndex;
    }

    public function relateTo($modelName)
    {
        if($this->sb->getName() === $modelName) {
            return true;
        } else if($this->ob->getName() === $modelName) {
            return true;
        } else {
            return false;
        }
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