<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverListBelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;

abstract class ResolverListBelongsToModel extends ResolverListBelongsToApp
{
    use BelongsToModel;

    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app);

        $this->setModel($model);
    }
}