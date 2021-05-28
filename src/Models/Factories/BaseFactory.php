<?php

namespace Erupt\Models\Factories;

use Erupt\Foundations\Resolver;
use Erupt\Traits\{HasParams, HasList, HasApp, HasModel, HasProp};

abstract class BaseFactory extends Resolver
{
    use HasParams,
        HasList,
        HasApp,
        HasModel,
        HasProp;

    public function __construct()
    {
        $this->setApp($app);

        $this->setModel($model);

        $this->setProperty($prop);
    }
}