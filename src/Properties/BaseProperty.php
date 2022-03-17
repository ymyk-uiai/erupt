<?php

namespace Erupt\Properties;

use Erupt\Foundation\BaseListItem;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Proposals\BaseProposal;
use Erupt\Attributes\BaseAttribute;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;
use Erupt\Values\Lists\ValueList;
use Erupt\ValidationRules\Lists\ValidationRuleList;
use Erupt\Flags\Lists\FlagList;

abstract class BaseProperty extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['p', 'prop', 'property'];

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
        return "Erupt\\Properties\\Items\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, BaseProposal $proposal, $scope = null): static
    {
        return static::init($ini)->extend($ini, $proposal, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name, BaseProposal $proposal, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $proposal, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
        $this->values = ValueList::init($ini);
        $this->validationRules = ValidationRuleList::init($ini);
        $this->flags = FlagList::init($ini);
    }

    public function extend(Ini $ini, BaseAttribute $attribute, $scope = null): self
    {
        $this->values->extend($ini, $attribute->getValues(), $attribute);
        $this->validationRules->extend($ini, $attribute->getValidationRules(), $attribute);
        $this->flags->extend($ini, $attribute->getFlags(), $attribute);
    
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

    protected function accessAdditionally(string $keys, int $index): Accessor
    {
        return $this->values->access($keys, $index);
    }
}