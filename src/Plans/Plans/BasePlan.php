<?php

namespace Erupt\Plans\Plans;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Plans\Properties\Lists\PropertyList;

abstract class BasePlan extends BaseListItem
{
    protected string $name;

    protected string $type;

    protected PropertyList $properties;

    public static function build($name, $data): Self
    {
        $plan = new Static;

        $plan->set_name($name);

        $plan->set_type($data["type"]);

        $plan->set_properties(PropertyList::build($data));

        return $plan;
    }

    public function set_name(string $name)
    {
        $this->name = $name;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_type(string $type)
    {
        $this->type = $type;
    }

    public function get_type(): string
    {
        return $this->type;
    }

    public function set_properties(PropertyList $properties)
    {
        $this->properties = $properties;
    }

    public function get_properties(): PropertyList
    {
        return $this->properties;
    }
}