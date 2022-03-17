<?php

namespace Erupt\Models;

use Erupt\Foundation\BaseListItem;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Plans\BasePlan;
use Erupt\Proposals\Lists\ProposalList;
use Erupt\Properties\BasePropertyList;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseModel extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['m', 'model'];

    public static function getClassSymbol(): string
    {
        return implode('\\', array_slice(explode('\\', static::class), 3));
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
        return "Erupt\\Models\\Items\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, BasePlan $plan, $scope = null): static
    {
        return static::init($ini)->extend($ini, $plan, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name, BasePlan $plan, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $plan, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
    }

    public function extend(Ini $ini, BasePlan $plan, $scope = null): self
    {
        $this->properties = BasePropertyList::buildWithItsName($ini, BasePropertyList::getDefaultClassSymbol(), $plan->getProposals(), $scope);
        return $this;
    }

    protected function split(string $descs): array
    {
        return preg_split("/[^|]|||[^|]/", $descs);
    }

    protected function parse(string $desc): array
    {
        return preg_split("/[^:]::[^:]/", $desc);
    }
}