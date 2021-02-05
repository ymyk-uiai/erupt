<?php

namespace Erupt\Plans\Methods\Items\Id;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\BigIncrements\Attribute as BigIncrementsAttribute;

class Attribute extends BaseAttribute
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
}