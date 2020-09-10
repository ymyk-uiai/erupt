<?php

namespace Erupt\Plans\Plans;

use Erupt\Abstracts\Plans\Plans\Plan as AbstractPlan;
use Erupt\Plans\Constructors\Plans\PlanConstructor;
use Erupt\Plans\Lists\Properties\PropertyList;

class Plan extends AbstractPlan
{
    protected $name;

    protected $type;

    protected PropertyList $properties;

    public function __construct()
    {
        //
    }

    public static function build($name, $data): Self
    {
        return PlanConstructor::build($name, $data);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties(PropertyList $properties)
    {
        $this->properties = $properties;
    }
}