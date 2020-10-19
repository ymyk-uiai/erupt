<?php

namespace Erupt\Abstracts\Models\Models;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Models\Lists\Properties\PropertyList;
use Erupt\Models\Lists\Files\FileList;

abstract class Model extends BaseListItem
{
    protected $name;

    protected $type;

    protected $properties;

    protected $relationships;

    protected $files;

    public function __construct()
    {
        //
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

    public function getFiles(): FileList
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function resolve($keys, $app)
    {
        //print_r("Model->resolve\n");

        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        //print_r(implode('.', $keys)."\n");

        $key = array_shift($keys);

        if($key == "attributes") {
            return $this->getProperties()->resolve($keys, $app);
        } else if($key == "relationships") {
            return $this->getRelationships()->resolve($keys, $app);
        } else if($key == "files") {
            return $this->getFiles()->resolve($keys, $app);
        } else {
            $props = [
                "name",
            ];
    
            if(in_array($key, $props)) {
                return $this->{$key};
            }
        }
    }
}