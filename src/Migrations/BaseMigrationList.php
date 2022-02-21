<?php

namespace Erupt\Migrations;

use Erupt\Foundation\BaseList;
use Erupt\Application;
use Erupt\Plans\Lists\PlanList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Generators\BaseGenerator;

abstract class BaseMigrationList extends BaseList
{
    protected Application $app;

    public static function build(Application $app, PlanList $plans, RelationshipList $relationships): self
    {
        return new static($app);
    }

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function add(BaseMigration|self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseMigration|self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}