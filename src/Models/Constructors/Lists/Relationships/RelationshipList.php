<?php

namespace Erupt\Models\Constructors\Lists\Relationships;

use Erupt\Models\Lists\Relationships\RelationshipList as Product;

class RelationshipList
{
    public static function build($model, $relationships): Product
    {
        $product = new Product;

        foreach($relationships as $relationship) {
            $relationship->getModelRelationships($model, $product);
        }

        return $product;
    }
}