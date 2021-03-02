<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Foundations\Lists\BaseList;
use Erupt\Models\Models\Items\App;
use Erupt\Models\Models\Items\Auth;
use Erupt\Models\Models\Items\Content;
use Erupt\Models\Models\Items\Binder;
use Erupt\Models\Models\Items\Response;
use Erupt\Models\Properties\Lists\PropertyList;
use Erupt\Models\Relationships\Lists\RelationshipList;

abstract class BaseModelList extends BaseList
{
    protected Application $app;

    public static function build($plans, $relationships, $app): Self
    {
        $modelList = new Static;

        $modelList->set_app($app);

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

            $model->set_schema_methods($plan);

            $model->set_properties(PropertyList::build($properties));

            $model->set_relationships(RelationshipList::build($model, $relationships, $app));

            $modelList->add($model);
        }

        return $modelList;
    }

    public function set_app(Application $app): void
    {
        $this->app = $app;
    }

    public function get_app(): Application
    {
        return $this->app;
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

        if($name == "app") {
            $app = new App;

            $app->set_app($this->get_app());

            return $app;
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