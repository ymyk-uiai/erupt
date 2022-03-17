<?php

namespace Erupt\Properties;

use Erupt\Foundation\BaseList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Proposals\BaseProposalList;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BasePropertyList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['ps', 'props', 'properties'];

    public static function getClassSymbol(): string
    {
        return array_slice(explode('\\', static::class), 0, 0);
    }

    public static function getDefaultClassSymbol(): string
    {
        return "PropertyList";
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
        return "Erupt\\Properties\\Lists\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, BaseProposalList $proposals, $scope = null): static
    {
        return static::init($ini)->extend($ini, $proposals, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name,  BaseProposalList $proposals, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $proposals, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
    }

    public function extend(Ini $ini, BaseProposalList $proposals, $scope = null): self
    {
        return array_reduce($proposals->items, function ($carry, $proposal) use ($ini) {
            $carry->add($proposal->makeProperties($ini));
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

    public function add(self|BaseProperty $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseProperty $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}