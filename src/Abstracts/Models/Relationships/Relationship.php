<?php

namespace Erupt\Abstracts\Models\Relationships;

use Erupt\Abstracts\Foundations\BaseListItem;

class Relationship extends BaseListItem
{
    protected string $name;

    protected bool $required = false;

    protected bool $index = false;

    protected bool $show = false;

    public function __construct(Member $member)
    {
        $this->name = $member->getName();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRequired(bool $bool)
    {
        $this->required = $bool;
    }

    public function setIndex(bool $bool)
    {
        $this->index = $bool;
    }

    public function setShow(bool $bool)
    {
        $this->show = $bool;
    }

    public function check($key)
    {
        $flags = [
            "required",
            "index",
            "show",
        ];

        if(in_array($key, $flags)) {
            return $this->{$key};
        }
    }

    public function resolve($keys, $app)
    {
        print_r("Relationship->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        print_r(implode('.', $keys)."\n");

        $key = array_shift($keys);

        $model = $app->getModels()->getModel($this->name);

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