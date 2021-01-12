<?php

namespace Erupt\Abstracts\Models\Models;

use Erupt\Abstracts\Foundations\BaseListItem;
use Erupt\Models\Lists\Properties\PropertyList;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Interfaces\Commanding;
use Erupt\Interfaces\Migrating;
use Erupt\Interfaces\FileMaker;
use Erupt\Interfaces\MigrationMaker;
use Erupt\Application;

abstract class Model extends BaseListItem implements Commanding, Migrating, FileMaker, MigrationMaker
{
    protected Application $app;

    protected string $name;

    protected PropertyList $properties;

    protected $relationships;

    public function set_app(Application $app)
    {
        $this->app = $app;
    }

    public function get_app(): Application
    {
        return $this->app;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function get_type(): string
    {
        return $this->get_model_type();
    }

    protected function get_model_type(): string
    {
        return "unknown";
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

    public function setFiles(FileList $files)
    {
        $this->files = $files;
    }

    public function make_file_specification()
    {
        //
    }

    public function make_migration_specification()
    {
        return $this->app->get_generators()->make_migration_specifications($this);
    }

    public function get_table_name()
    {
        //  $this->table_name()
        return $this->name;
    }

    public function get_command(): string
    {
        return "create_{$this->name}_table";
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
            return $app->get_files()->resolve($this, $keys, $app);
            //return $this->getFiles()->resolve($this, $keys, $app);
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