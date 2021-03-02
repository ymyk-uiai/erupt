<?php

namespace Erupt\Plans\Methods\Items\RememberToken;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\String\Attribute as StringAttribute;
use Erupt\Interfaces\SchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    public static function build($args): Self
    {
        $product = new Self;

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }
    
    public function run()
    {
        $updaterList = new UpdaterList;

        $a = StringAttribute::build([
            "name" => "remember_token",
            "length" => 100,
        ]);

        $u = $a->run();

        $updaterList->add($u);

        return $updaterList;
    }

    public function get_schema_method(): string
    {
        return "rememberToken()";
    }
}