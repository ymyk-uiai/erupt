<?php

namespace Erupt\Plans\Methods\Items\String;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\String\Updater as StringUpdater;
use Erupt\Interfaces\SchemaMethod;
use Erupt\Models\SchemaMethods\Items\String\Method as StringSchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    //  protected string $params = "name :string, length? :int";

    protected $name;

    protected $length = 100;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name, length?", $args);

        $product->set_name($params["name"]);

        $product->set_length($params["length"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_length($length)
    {
        $this->length = $length ?? $this->length;
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = StringUpdater::build(["name" => $this->name, "length" => $this->length]);

        $updaterList->add($updater);

        return $updaterList;
    }

    public function get_schema_method(): string
    {
        return "string('{$this->name}', {$this->length})";
    }

    public function get_schema_method_2()
    {
        return $this;
    }
}