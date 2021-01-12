<?php

namespace Erupt\Plans\Tools\Id;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Tools\BigIncrements\Attribute as BigIncrementsAttribute;

class Attribute extends AbstractAttribute
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