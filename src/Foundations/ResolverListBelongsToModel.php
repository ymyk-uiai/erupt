<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverList;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;

abstract class ResolverListBelongsToModel extends ResolverList
{
    use BelongsToApp, BelongsToModel;

    public function __construct(Application $app, Model $model)
    {
        $this->setApplication($app);
        $this->setModel($model);
    }

    public function makeEmpty(): Static
    {
        return new Static($this->app, $this->model);
    }

    public function startDebug(): void
    {
        unset($this->app, $this->model);

        foreach($this->list as $item) {
            $item->startDebug();
        }
    }
}