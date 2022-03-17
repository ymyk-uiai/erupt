<?php

namespace Erupt\Values;

use Erupt\Foundation\BaseListItem;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Traits\HasParams;
use Erupt\Attributes\BaseAttribute;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseValue extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize,
        HasParams;

    protected static array $accessKeys = ['v', 'value'];

    public static function getClassSymbol(): string
    {
        return implode('\\', array_slice(explode('\\', static::class), 3, -1));
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
        return "Erupt\\Values\\Items\\".ucfirst($className)."\\Value";
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

    public function __toString(): string
    {
        return $this->args["value"];
    }
}