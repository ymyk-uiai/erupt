<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverItemBelongsToModel;
use Erupt\Traits\BelongsToProp;
use Erupt\Application;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Models\Properties\BaseProperty as Prop;

abstract class ResolverItemBelongsToProp extends ResolverItemBelongsToModel
{
    use BelongsToProp;

    public function __construct(Application $app, Model $model, Prop $prop)
    {
        parent::__construct($app, $model);

        $this->setProp($prop);
    }
}