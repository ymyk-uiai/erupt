<?php

namespace Erupt\Plans\Lists\Properties;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Plans\Constructors\Lists\Properties\PropertyListConstructor;

class PropertyList extends BaseList
{
    public function __construct()
    {
        //
    }

    public static function build($plans)
    {
        return PropertyListConstructor::build($plans);
    }
    
    public function add($property)
    {
        parent::add($property);
    }
}