<?php

namespace Erupt\Plans\Methods\Items\Id;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\BigIncrements\Attribute as BigIncrementsAttribute;
use Erupt\Interfaces\SchemaMethod;
use Erupt\Models\SchemaMethods\Items\Id\Method as IdSchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function run()
    {
        $m = BigIncrementsAttribute::build(["name" => "id"]);

        $fl = $m->run();

        return $fl;
    }

    public function get_schema_method(): string
    {
        return "id()";
    }

    public function get_schema_method_2()
    {
        return $this;
    }
}