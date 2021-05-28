<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverItemBelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;

abstract class ResolverItemBelongsToModel extends ResolverItemBelongsToApp
{
    use BelongsToModel;

    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app);

        $this->setModel($model);
    }
}