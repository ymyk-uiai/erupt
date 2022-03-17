<?php

namespace Erupt\Attributes\Items\String;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;
use Erupt\Foundation\Initializer as Ini;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name,length?";

    protected ?string $values = "name:{name}|columnType:VARCHAR|valueType:string";

    /*
    public function __construct(Ini $ini)
    {
        print_r("String\n");
        print_r($this);
        //$this->initialize($ini);
    }

    public function getValues(): string
    {
        print_r("String->getValues()\n");
        print_r(empty($this->values) ? "\n" : $this->values."\n");
        return empty($this->values) ? "" : $this->values;
    }
    */
}