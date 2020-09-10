<?php

namespace Erupt\Models\Constructors\Lists\Files;

use Erupt\Models\Lists\Files\FileList as Product;

class FileList
{
    public static function build($model, $server, $front): Product
    {
        $product = new Product;

        $product->add($server->getFiles($model));

        return $product;
    }

    public static function pack(): FileList
    {
        //
    }
}