<?php

namespace Erupt\Migrations\Lists;

use Erupt\Migrations\BaseMigrationList;
use Erupt\Plans\Lists\PlanList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Application;

class MigrationList extends BaseMigrationList
{
    public static function build(Application $app, PlanList $plans, RelationshipList $relationships): self
    {
        $product = parent::build($app, $plans, $relationships);

        $generator = $app->getMigrationGenerator();

        foreach($plans as $plan) {
            if($generator->isTarget($plan)) {
                $product->add($generator->generate($plan));
            }
        }

        foreach($relationships as $relationship) {
            if($generator->isTarget($relationship)) {
                $product->add($generator->generate($relationship));
            }
        }

        return $product;
    }
}