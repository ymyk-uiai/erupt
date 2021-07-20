<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverItem;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Traits\BelongsToProperty;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Property;

abstract class ResolverItemBelongsToProperty extends ResolverItem
{
    use BelongsToApp, BelongsToModel, BelongsToProperty;

    public function __construct(Application $app, Model $model, Property $prop)
    {
        $this->setApplication($app);
        $this->setModel($model);
        $this->setProperty($prop);
    }

    public function startDebug(): void
    {
        unset($this->app, $this->model, $this->property);

        foreach($this as $value) {
            if(is_object($value) && method_exists($value, 'startDebug')) {
                $value->startDebug();
            }
        }
    }
}