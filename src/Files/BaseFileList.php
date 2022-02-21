<?php

namespace Erupt\Files;

use Erupt\Foundation\BaseList;
use Erupt\Application;
use Erupt\Plans\Lists\PlanList;
use Erupt\Relationships\Lists\RelationshipList;

abstract class BaseFileList extends BaseList
{
    public static function build(Application $app, PlanList $plans, RelationshipList $relationships): self
    {
        $file = new static;

        $file->app = $app;

        return $file;
    }

    public function add(BaseFile|self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseFile|self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}