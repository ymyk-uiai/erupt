<?php

namespace Erupt\Models\Properties\Lists;

use Erupt\Models\Properties\BasePropertyList;

class PropertyList extends BasePropertyList
{
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
            if($property->get_flag($key)) {
                $properties->add($property);
            }
        }

        return $properties->resolve($keys);
    }
}