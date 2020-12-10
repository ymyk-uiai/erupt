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
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

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