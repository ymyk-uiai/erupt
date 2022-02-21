<?php

namespace Erupt\Plans;

use Erupt\Foundation\BaseList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Plans\Items\{User, Post, Folder, Comment};

abstract class BasePlanList extends BaseList
{
    public static function build(array $plans, RelationshipList $relationships): static
    {
        $product = new static;
        foreach($plans as $model => $plan) {
            $product->add(self::buildPlan($model, $plan, $relationships));
        }
        return $product;
    }

    protected static function buildPlan(string $model, array $plan, RelationshipList $relationships): BasePlan
    {
        try {
            return match ($model) {
                "user" => User::build($plan, $relationships),
                "post" => Post::build($plan, $relationships),
                "folder" => Folder::build($plan, $relationships),
                "comment" => Comment::build($plan, $relationships),
                default => throw new Exception($model),
            };
        } catch (Exception $e) {
            echo 'Unknown model type: ', $e->getMessage(), "\n";
        }
    }

    public function add(BasePlan|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BasePlan|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}