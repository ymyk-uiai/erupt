<?php

namespace Erupt\Models\Constructors\Relationships;

use Erupt\Models\Relationships\Relationship as Product;

class Relationship
{
    public static function build($member): Product
    {
        $modelRelationship = new Product;

        $modelRelationship->setName($member->getName());

        foreach($member->getUpdaters() as $updater) {
            $updater->update($modelRelationship);
        }

        return $modelRelationship;
    }
}