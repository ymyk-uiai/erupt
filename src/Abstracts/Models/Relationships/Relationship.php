<?php

namespace Erupt\Abstracts\Models\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;

class Relationship extends BaseListItem
{
    protected $name;

    protected array $flags = [];

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFlag(string $flagKey): bool
    {
        if(array_key_exists($flagKey, $this->flags)) {
            return $this->flags[$flagKey];
        } else {
            return false;
        }
    }

    public function setFlag(string $flagKey, bool $bool)
    {
        $this->flags[$flagKey] = $bool;
    }

    public function resolve($keys, $app)
    {
        //print_r("Relationship->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        //print_r(implode('.', $keys)."\n");

        $key = array_shift($keys);

        $model = $app->getModels()->get($this->name);

        if($key == "attributes") {
            return $model->getProperties()->resolve($keys, $app);
        } else if($key == "relationships") {
            return $model->getRelationships()->resolve($keys, $app);
        } else {
            array_unshift($keys, $key);
            return $model->resolve($keys, $app);
        }
    }
}