<?php

namespace Erupt\Models\ModelValues;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToModel;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Models\BaseModel as Model;

abstract class BaseModelValue extends ResolverItemBelongsToModel
{
    protected int|string|bool $value;

    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app, $model);
    }

    public function build($value): void
    {
        $this->value = $value;
    }

    abstract public function getKey(): string;

    public function setValue(int|string|bool $value)
    {
        $this->value = $value;
    }

    public function getValue(): int|string|bool
    {
        return $this->value;
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