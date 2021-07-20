<?php

namespace Erupt\Models\ModelFlags;

use Erupt\Application;
use Erupt\Foundations\ResolverListBelongsToModel;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;

abstract class BaseModelFlagList extends ResolverListBelongsToModel
{
    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app, $model);
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($model): void
    {
        parent::addItemOrList($model);
    }

    public function remove($model): void
    {
        parent::removeItemOrList($model);
    }
}