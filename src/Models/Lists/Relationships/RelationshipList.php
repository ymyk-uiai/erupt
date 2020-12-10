<?php

namespace Erupt\Models\Lists\Relationships;

use Erupt\Abstracts\Foundations\BaseList;

class RelationshipList extends BaseList
{
    public function add($relationship)
    {
        parent::add($relationship);
    }

    public function remove($relationship)
    {
        parent::remove($relationship);
    }

    public function resolve($keys, $app)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $relationships = new Self;

        foreach($this->list as $relationship) {
            if($relationship->getFlag($key)) {
                $relationships->add($relationship);
            }
        }

        return $relationships->resolve($keys, $app);
    }

    public function resolve1($keys, $app)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $relationships = new Self;

        foreach($this->list as $relationship) {
            if($relationship->getFlag($key)) {
                return $relationship;
            }
        }
    }
}