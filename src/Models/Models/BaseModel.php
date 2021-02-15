<?php

namespace Erupt\Models\Models;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Interfaces\Makers\Items\FileMaker;
use Erupt\Interfaces\Makers\Items\MigrationMaker;
use Erupt\Application;
use Erupt\Models\Properties\Lists\PropertyList;
use Erupt\Models\Relationships\Lists\RelationshipList;

abstract class BaseModel extends BaseListItem implements FileMaker, MigrationMaker
{
    protected Application $app;

    protected string $name;

    protected string $table_name;

    protected PropertyList $properties;

    protected RelationshipList $relationships;

    public static function build($name): Self
    {
        $product = new Static;

        $product->set_name($name);

        return $product;
    }

    public function set_app(Application $app)
    {
        $this->app = $app;
    }

    public function get_app(): Application
    {
        return $this->app;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_name(string $name)
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

    public function get_properties(): PropertyList
    {
        return $this->properties;
    }

    public function set_properties(PropertyList $properties)
    {
        $this->properties = $properties;
    }

    public function get_relationships(): RelationshipList
    {
        return $this->relationships;
    }

    public function set_relationships(RelationshipList $relationships)
    {
        $this->relationships = $relationships;
    }

    public function set_table_name(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function get_table_name(): string
    {
        return $this->table_name;
    }

    public function get_command(): string
    {
        return "create_{$this->name}_table";
    }

    public function resolve($keys)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        if($key == "attributes" || $key == "props") {
            return $this->get_properties()->resolve($keys, $this->app);
        } else if($key == "relationships") {
            return $this->get_relationships()->resolve($keys, $this->app);
        } else if($key == "relationship") {
            return $this->get_relationships()->resolve1($keys, $this->app);
        } else if($key == "files") {
            return $this->app->get_file_specs()->resolve($this, $keys);
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