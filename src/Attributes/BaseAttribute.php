<?php

namespace Erupt\Attributes;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;
use Erupt\Attributes\Containers\AttributeContainer;
use Erupt\Attributes\Lists\AttributeList;
use Erupt\Interfaces\TableColumnMaker;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;

abstract class BaseAttribute extends BaseListItem implements Accessor
{
    use HasParams,
        HandleInitialize,
        HandleAccess;

    protected ?string $alias;

    protected ?string $values;

    protected ?string $validationRules;

    protected ?string $flags;

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
        return "Erupt\\Attributes\\Items\\".ucfirst($className)."\\Attribute";
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
        //  $args = evalArgs($args, $scope);
        if(isset($scope)) {
            $desc = preg_replace_callback(
                "/({(\w+)})(.*)/",
                function ($matches) use ($scope) {
                    return $scope->getArg($matches[2]).$matches[3];
                },
                $desc
            );
        }

        $this->takeArgs(trim($desc, ":"));

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

    public function getValues(): string
    {
        return empty($this->values) ? "" : $this->values;
    }

    public function getValidationRules(): string
    {
        return empty($this->validationRules) ? "" : $this->validationRules;
    }

    public function getFlags(): string
    {
        return empty($this->flags) ? "" : $this->flags;
    }

    public function isTableColumnMaker(): bool
    {
        return $this instanceof TableColumnMaker;
    }

    public function evaluate(): BaseAttributeContainer
    {
        if(empty($this->alias)) {
            return AttributeContainer::wrap($this->makeIni(), $this);
        }

        $proposals = explode('||', $this->alias);

        $container = AttributeContainer::init($this->makeIni());
        foreach($proposals as $attributeList) {
            $container->add(AttributeList::build($this->makeIni(), $attributeList, $this));
        }

        return $container->evaluate();
    }
}