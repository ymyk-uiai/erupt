<?php

namespace Erupt\Models\Factories;

use Erupt\Foundations\Resolver;
use Erupt\Traits\{HasList, HasApp, HasModel, HasProp};

abstract class BaseFactoryList extends Resolver
{
    use HasList, HasApp, HasModel, HasProp;

    public function __construct()
    {
        $this->setApp($app);

        $this->setModel($model);

        $this->setProperty($prop);
    }

    public function getResolver(): Resolver
    {
        //
    }

    public function add()
    {
        //
    }

    public function remove()
    {
        //
    }
}