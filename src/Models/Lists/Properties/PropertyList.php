<?php

namespace Erupt\Models\Lists\Properties;

use Erupt\Abstracts\Foundations\BaseList;

class PropertyList extends BaseList
{
    public function add($property)
    {
        parent::add($property);
    }

    public function remove($property)
    {
        parent::remove($property);
    }

    public function resolve($keys)
    {
        print_r("PropertyList->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        print_r(implode('.', $keys)."\n");

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $properties = new PropertyList;

        foreach($this->list as $property) {
            if($property->getFlag($key)) {
                $properties->add($property);
            }
        }

        return $properties->resolve($keys);
    }
}