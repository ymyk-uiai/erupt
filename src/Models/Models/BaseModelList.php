<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Models\Models\Items\{App, User, Post, Folder, Comment};
use Erupt\Plans\Plans\Lists\PlanList;
use Exception;
use Erupt\Foundations\ResolverList;
use Erupt\Traits\BelongsToApp;
use Erupt\Interfaces\Resolver;
use Erupt\Plans\Properties\Lists\PropertyList;

abstract class BaseModelList extends ResolverList
{
    use BelongsToApp;
    
    public function __construct(Application $app, PlanList $plans)
    {
        $this->setApp($app);

        foreach($plans as $plan) {
            try {
                $this->add(match($plan->getType()) {
                    "user" => new User($app, $plan->getProperties()),
                    "post" => new Post($app, $plan->getProperties()),
                    "folder" => new Folder($app, $plan->getProperties()),
                    "comment" => new Comment($app, $plan->getProperties()),
                    default => throw new Exception($plan->getType()),
                });
            } catch (Exception $e) {
                echo 'Unknown model type: ', $e->getMessage(), "\n";
            }
        }

        $this->addApp($app);
    }

    protected function addApp($app): void
    {
        $this->add(new App($app, PropertyList::empty()));
    }

    public function add($model): void
    {
        parent::addItemOrList($model);
    }

    public function remove($model): void
    {
        parent::removeItemOrList($model);
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
        return $this;
    }

    public function evaluate()
    {
        return $this;
    }
}