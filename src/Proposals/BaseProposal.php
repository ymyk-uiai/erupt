<?php

namespace Erupt\Proposals;

use Erupt\Foundation\BaseListItem;
use Erupt\Attributes\BaseAttributeList;
use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\BasePropertyList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseProposal extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['pr', 'proposal'];


    public static function getClassSymbol(): string
    {
        return implode('\\', array_slice(explode('\\', static::class), 3));
    }

    public static function getDefaultClassSymbol(): string
    {
        return "DefaultClassSymbol";
    }

    protected static function getCorrespondingContainerName(): string
    {
        return static::getClassSymbol();
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
        return "Erupt\\Proposals\\Items\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, string $desc, $scope = null): static
    {
        return static::init($ini)->extend($ini, $desc, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name, string $desc, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $desc, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
    }

    public function extend(Ini $ini, string $desc, $scope = null): self
    {
        $this->attributes = BaseAttributeList::buildWithItsName($ini, BaseAttributeList::getDefaultClassSymbol(), $desc, $scope);
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

    public function getAttributeList(): BaseAttributeList
    {
        return $this->attributes;
    }

    public function makeProperties(Ini $ini): BasePropertyList
    {
        $container = BaseAttributeContainer::initWithItsName($ini, static::getCorrespondingContainerName());

        foreach($this->attributes as $attribute) {
            $container->merge($attribute->evaluate());
        }

        return $container->makeProperties($ini);
    }
}