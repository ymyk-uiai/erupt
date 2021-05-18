<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Interfaces\Makers\Items\FileMaker;
use Erupt\Interfaces\Makers\Items\MigrationMaker;
use Erupt\Models\Models\ValidationRules\List\ValidationRuleList;
use Erupt\Models\Properties\Lists\PropertyList;
use Erupt\Models\Relationships\Lists\RelationshipList;
use Erupt\Models\SchemaMethods\Containers\SchemaMethodContainer;
use Erupt\Models\SchemaMethods\Lists\SchemaMethodList;

abstract class BaseModel extends BaseListItem implements FileMaker, MigrationMaker
{
    protected Application $app;

    protected string $name;

    protected string $table_name;

    protected SchemaMethodContainer $schema_methods_test;

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

    public function get_validation_rules(): ValidationRuleList
    {
        return $this->validation_rules;
    }

    public function set_table_name(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function get_table_name(): string
    {
        return $this->table_name;
    }

    public function getOrdinaryFlags(string $name): array
    {
        return match(array_key_exists($name, Static::$ordinaryFlags)) {
            true => Static::$ordinaryFlags[$name],
            false => [],
        };
    }

    public function getRelationshipFlags(string $name): array
    {
        return match(array_key_exists($name, Static::$relationshipFlags)) {
            true => Static::$relationshipFlags[$name],
            false => [],
        };
    }

    public function get_command(): string
    {
        return "create_{$this->name}_table";
    }

    public function set_schema_methods_test($plan): void
    {
        $schema_methods = new SchemaMethodContainer;

        foreach($plan->get_properties() as $property) {
            $schema_methods->add($property->get_methods());
        }

        $this->schema_methods_test = $schema_methods;
    }

    public function get_schema_methods_test(): SchemaMethodContainer
    {
        return $this->schema_methods_test;
    }

    public function set_schema_methods($plan): void
    {
        $schema_methods = [];

        foreach($plan->get_properties() as $property) {
            $schema_methods[] = $property->get_method();
        }

        $this->schema_methods = implode(";\n", $schema_methods);
    }

    public function get_migration(): string
    {
        return $this->schema_methods;
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
        } else if($key == "validation_rules") {
            return $this->get_validation_rules()->resolve($keys);
        } else if($key == "symbol") {
            //  make $this->symbols
            $symbols = [
                "name" => $this->name,
                "name_plural" => $this->name . "s",
                "instance" => $this->name,
                "instance_plural" => $this->name . "s",
            ];

            $key = array_shift($keys);

            if(array_key_exists($key, $symbols)) {
                return $symbols[$key];
            }
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