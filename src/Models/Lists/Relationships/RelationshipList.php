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
        print_r("RelationshipList->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        print_r(implode('.', $keys)."\n");

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
}