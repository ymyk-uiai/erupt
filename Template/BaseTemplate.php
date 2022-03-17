<?php

namespace Erupt\Templates;

use Erupt\Foundation\BaseListItem;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseTemplate extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['r', 'rel', 'relationship'];

    public static function getClassSymbol(): string
    {
        return implode('\\', array_slice(explode('\\', static::class), 3));
    }

    public static function getDefaultClassSymbol(): string
    {
        return "Template";
    }

    public static function split(string $rest): array
    {
        return preg_split("/\|{?}/", $rest);
    }

    public static function parse(string $desc): array
    {
        return preg_split("/:{?}/", $desc);
    }

    public static function init(Ini $ini): static
    {
        return new static($ini);
    }

    protected static function initWithSymbol(Ini $ini, string $symbol): self
    {
        return self::instantiate($ini, self::makeClassName($symbol));
    }

    protected static function initWithoutSymbol(Ini $ini): self
    {
        return self::instantiate($ini, static::makeClassName(static::makeSymbol(new \ReflectionClass(static::class))));
    }

    protected static function makeSymbol(\ReflectionClass $reflection): string
    {
        return $reflection->isAbstract() ? static::getDefaultClassSymbol() : static::getClassSymbol();
    }

    protected static function makeClassName(string $symbol): string
    {
        return "Erupt\\Templates\\Items\\".ucfirst($symbol)."\\Template";
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, string $desc, $scope = null): self
    {
        [$symbol, $sp, $rest] = static::parse($desc);

        return empty($symbol) ? static::buildWithName($ini, $symbol, $desc, $scope) : static::buildWithoutName($ini, $rest, $scope);
    }

    protected static function buildWithSymbol(Ini $ini, string $symbol, string $rest, $scope = null): self
    {
        return static::initWithSymbol($ini, $symbol)->extend($ini, $rest, $scope);
    }

    protected static function buildWithoutSymbol(Ini $ini, string $rest, $scope = null): self
    {
        return static::initWithoutSymbol($ini)->extend($ini, $rest, $scope);
    }

    public function __construct(Ini $ini)
    {
        $this->initialize($ini);
    }

    public function extend(Ini $ini, string $args, $scope = null): self
    {
        return $this->evalAndTakeArgs($args, $scope);
    }
}