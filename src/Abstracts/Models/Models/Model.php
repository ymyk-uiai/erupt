<?php

namespace Erupt\Abstracts\Models\Models;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Models\Lists\Properties\PropertyList;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Interfaces\Commanding;
use Erupt\Interfaces\Migrating;

abstract class Model extends BaseListItem implements Commanding, Migrating
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
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        if($key == "attributes") {
            return $this->getProperties()->resolve($keys, $app);
        } else if($key == "relationships") {
            return $this->getRelationships()->resolve($keys, $app);
        } else if($key == "relationship") {
            return $this->getRelationships()->resolve1($keys, $app);
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

    public function getCommandSeeds($app)
    {
        $commandSeedKeys = $this->getCommandSeedKeys();

        // foreach($this->generators as $generator) { ... }

        $name = ucfirst($this->name);

        $commandSeeds1 = $app->server->getCommandSeeds($commandSeedKeys, $name);
        $commandSeeds2 = $app->front->getCommandSeeds($commandSeedKeys, $name);

        return array_merge($commandSeeds1, $commandSeeds2);
    }

    public function getMigrationCommandSeeds($app)
    {
        //
    }
}