<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Foundations\ResolverListBelongsToApp;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\Items;
use Erupt\Plans\Plans\Lists\PlanList;
use Erupt\Plans\Properties\Lists\PropertyList;
use Exception;

abstract class BaseModelList extends ResolverListBelongsToApp
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function build(PlanList $plans)
    {
        $this->addApplication();

        foreach($plans as $plan) {
            try {
                $model = match($plan->getType()) {
                    "user" => new Items\User($this->app),
                    "post" => new Items\Post($this->app),
                    "folder" => new Items\Folder($this->app),
                    "comment" => new Items\Comment($this->app),
                    default => throw new Exception($plan->getType()),
                };
                $model->build($plan->getProperties());
                $this->add($model);
            } catch (Exception $e) {
                echo "Unknown model type:\t", $e->getMessage(), "\n";
            }
        }
    }

    protected function addApplication(): void
    {
        $this->add(new Items\App($this->app));
    }

    public function get(string $type): BaseModel
    {
        try {
            foreach($this as $model) {
                if($model->getType() == trim($type)) {
                    return $model;
                }
            }
            throw new Exception($type);
        } catch (Exception $e) {
            echo 'Unknown model type: ', $e->getMessage(), "\n";
        }
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $models = Static::makeEmpty();

        foreach($this->list as $model) {
            if($model->checkFlag($key)) {
                $models->add($model);
            }
        }

        return $models;
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($model): void
    {
        parent::addItemOrList($model);
    }

    public function remove($model): void
    {
        parent::removeItemOrList($model);
    }
}