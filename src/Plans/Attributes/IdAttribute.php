<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Attributes\BigIncrementsAttribute;

class IdAttribute extends AbstractAttribute
{
    public static function build(): Self
    {
        $product = new Self;

        return $product;
    }

    public function __construct()
    {
        //
    }

    public function run()
    {
        $m = BigIncrementsAttribute::build(["name" => "id"]);

        $fl = $m->run();

        return $fl;
    }
}