<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverItem;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;

abstract class ResolverItemBelongsToModel extends ResolverItem
{
    use BelongsToApp, BelongsToModel;

    public function __construct(Application $app, Model $model)
    {
        $this->setApplication($app);
        $this->setModel($model);
    }

    public function startDebug(): void
    {
        unset($this->app, $this->model);

        foreach($this as $value) {
            if(is_object($value) && method_exists($value, 'startDebug')) {
                $value->startDebug();
            }
        }
    }
}