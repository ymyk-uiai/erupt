<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\IdAttributeConstructor;
use Erupt\Plans\Constructors\Attributes\BigIncrementsAttribute;

class IdAttribute extends AbstractAttribute
{
    public function __construct()
    {
        //
    }

    public static function build(): Self
    {
        return IdAttributeConstructor::build();
    }
    
    public function run()
    {
        $m = BigIncrementsAttribute::build(["name" => "id"]);

        $fl = $m->run();

        return $fl;
    }
}