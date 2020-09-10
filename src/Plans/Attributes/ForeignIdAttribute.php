<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\ForeignIdAttributeConstructor;

class ForeignIdAttribute extends AbstractAttribute
{
    protected $name;

    public function __construct()
    {
        //
    }

    public static function build($args): Self
    {
        return ForeignIdAttributeConstructor::build($args);
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function run()
    {
        $a = new UnsignedBigIntegerAttribute(["name" => $this->name]);

        $u = $a->run();

        return $u;
    }
}