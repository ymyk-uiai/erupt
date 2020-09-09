<?php

namespace Erupt\Abstracts\Models\Models;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Lists\PropertyList;

abstract class Model extends BaseListItem
{
    protected $name;

    protected $type;

    protected $properties;

    protected $relationships;

    protected $files;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties(PropertyList $properties)
    {
        $this->properties = $properties;
    }

    public function getRelationships()
    {
        return $this->relationships;
    }

    public function setRelationships($relatedModels)
    {
        $this->relationships = $relatedModels;
    }

    public function setModelFiles($files)
    {
        $this->files = $files;
    }
}