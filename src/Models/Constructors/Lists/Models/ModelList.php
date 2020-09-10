<?php

namespace Erupt\Models\Constructors\Lists\Models;

use Erupt\Models\Lists\Models\ModelList as Product;
use Erupt\Models\Constructors\Models\Auth;
use Erupt\Models\Constructors\Models\Content;
use Erupt\Models\Constructors\Models\Binder;
use Erupt\Models\Constructors\Models\Response;
use Erupt\Models\Constructors\Lists\Properties\PropertyList;
use Erupt\Models\Constructors\Lists\Relationships\RelationshipList;
use Erupt\Models\Constructors\Lists\Files\FileList;


class ModelList
{
    public static function build($plans, $relationships, $server, $front): Product
    {
        $modelList = new Product;

        foreach($plans as $plan) {
            $name = $plan->getName();
            $type = $plan->getType();
            $properties = $plan->getProperties();

            if($type == "auth") {
                $model = Auth::build($name);
            } else if($type == "content") {
                $model = Content::build($name);
            } else if($type == "binder") {
                $model = Binder::build($name);
            } else if($type == "response") {
                $model = Response::build($name);
            } else {
                // Unknown model type
            }

            $model->setProperties(PropertyList::build($properties));

            $model->setRelationships(RelationshipList::build($model, $relationships));

            $model->setFiles(FileList::build($model, $server, $front));

            $modelList->add($model);
        }

        return $modelList;
    }
}