<?php

namespace Erupt\Models\ModelFlags;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToModel;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;

abstract class BaseModelFlag extends ResolverItemBelongsToModel
{
    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app, $model);
    }

    public function build(string $key): void
    {
        $this->name = $key;
        $this->bool = true;
    }

    public function check(string $name): bool
    {
        return $this->name == $name && $this->bool;
    }

    public function getResolver(string $key, array &$keys): Resolver
    {
        return $this;
    }

    public function evaluate()
    {
        return $this->value;
    }
}