<?php

namespace Erupt\Models;

use Erupt\Foundation\BaseList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Plans\BasePlanList;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseModelList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['ms', 'models', 'modelList'];

    public static function getClassSymbol(): string
    {
        return array_slice(explode('\\', static::class), 0, 0);
    }

    public static function getDefaultClassSymbol(): string
    {
        return "DefaultClassSymbol";
    }

    public static function init(Ini $ini): static
    {
        return new static($ini);
    }

    public static function initWithItsName(Ini $ini, string $name): self
    {
        return self::instantiate($ini, self::makeClassName($name));
    }

    protected static function makeClassName(string $className): string
    {
        return "Erupt\\Models\\Lists\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, BasePlanList $plans, $scope = null): static
    {
        return static::init($ini)->extend($ini, $plans, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name, BasePlanList $plans, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $descs, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
    }

    public function extend(Ini $ini, BasePlanList $plans, $scope = null): self
    {
        return array_reduce($plans->items, function ($carry, $plan) use ($ini, $scope) {
            $carry->add(BaseModel::buildWithItsName($ini, $plan->getClassSymbol(), $plan, $scope));
            return $carry;
        }, $this);
    }

    protected function split(string $descs): array
    {
        return preg_split("/[^|]|||[^|]/", $descs);
    }

    protected function parse(string $desc): array
    {
        return preg_split("/[^:]::[^:]/", $desc);
    }

    public function add(self|BaseModel $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseModel $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function getModel(string $name): BaseModel
    {
        foreach($this->items as $model) {
            if($model->getClassSymbol() == ucfirst($name)) {
                return $model;
            }
        }

        throw new \Exception($name);
    }
}