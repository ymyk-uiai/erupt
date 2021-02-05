<?php

namespace Erupt\Models\Models;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Models\Models\Items\Auth;
use Erupt\Models\Models\Items\Content;
use Erupt\Models\Models\Items\Binder;
use Erupt\Models\Models\Items\Response;
use Erupt\Models\Properties\Lists\PropertyList;
use Erupt\Models\Relationships\Lists\RelationshipList;

abstract class BaseModelList extends BaseList
{
    public static function build($plans, $relationships, $app): Self
    {
        $modelList = new Static;

        foreach($plans as $plan) {
            $name = $plan->get_name();
            $type = $plan->get_type();
            $properties = $plan->get_properties();

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

            $model->set_app($app);

            $model->set_properties(PropertyList::build($properties));

            $model->set_relationships(RelationshipList::build($model, $relationships));

            $modelList->add($model);
        }

        return $modelList;
    }

    //  Unit Type BaseModel|BaseModelList
    public function add($model)
    {
        parent::add($model);
    }

    public function remove($model)
    {
        parent::remove($model);
    }

    public function get($name)
    {
        foreach($this->list as $model) {
            if($model->get_name() == $name) {
                return $model;
            }
        }

        return false;
    }

    public function get_by_type($type)
    {
        foreach($this->list as $model) {
            if($model->get_type() == $type) {
                return $model;
            }
        }

        return false;
    }
}