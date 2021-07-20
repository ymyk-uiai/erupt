<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverList;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Traits\BelongsToProperty;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Prop;

abstract class ResolverListBelongsToProperty extends ResolverList
{
    use BelongsToApp, BelongsToModel, BelongsToProperty;

    public function __construct(Application $app, Model $model, Prop $prop)
    {
        $this->setApplication($app);
        $this->setModel($model);
        $this->setProperty($prop);
    }

    public function makeEmpty(): Static
    {
        return new Static($this->app, $this->model, $this->property);
    }

    public function startDebug(): void
    {
        unset($this->app, $this->model, $this->property);

        foreach($this->list as $item) {
            $item->startDebug();
        }
    }
}