<?php

namespace Erupt\Specifications\Specifications\Items;

use Erupt\Specifications\Specifications\Bases\BaseSpecification;

class FileSpecification extends BaseSpecification
{
    protected string $name;

    public static function build($command)
    {
        $product = new Self;

        $product->command = $command["command"];

        $product->name = $command["name"];

        $product->model_name = $command["modelName"];

        return $product;
    }
}