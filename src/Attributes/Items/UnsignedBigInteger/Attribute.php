<?php

namespace Erupt\Attributes\Items\UnsignedBigInteger;

use Erupt\Attributes\BaseAttribute;
use Erupt\Interfaces\TableColumnMaker;
use Erupt\Foundation\Initializer as Ini;

class Attribute extends BaseAttribute implements TableColumnMaker
{
    protected string $params = "name";

    protected ?string $values = "name:{name}|columnType:UNSIGNED BIGINT|valueType:integer";
    
    /*
    public function extend(Ini $ini, string $desc, $scope = null): self
    {
        //  $args = evalArgs($args, $scope);
        if(isset($scope)) {
            $desc = preg_replace_callback(
                "/({(\w+)})(.*)/",
                function ($matches) use ($scope) {
                    return $scope->getArg($matches[2]).$matches[3];
                },
                $desc
            );
        }
    
        $this->takeArgs(trim($desc, ":"));
    
        print_r("UnsignedBigInteger\n");
        print_r($this);
    
        return $this;
    }
    */
}