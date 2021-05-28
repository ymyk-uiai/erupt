<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverListBelongsToModel;
use Erupt\Traits\BelongsToProp;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Prop;

abstract class ResolverListBelongsToProp extends ResolverListBelongsToModel
{
    use BelongsToProp;

    public function __construct(Application $app, Model $model, Prop $prop)
    {
        parent::__construct($app, $model);

        $this->setProp($prop);
    }
}