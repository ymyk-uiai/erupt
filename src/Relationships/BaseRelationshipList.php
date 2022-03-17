<?php

namespace Erupt\Relationships;

use Erupt\Foundation\BaseList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseRelationshipList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['rs', 'rels', 'relationships', 'relationshipList'];

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
        return "Erupt\\Relationships\\Lists\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function build(Ini $ini, string $descs, $scope = null): static
    {
        return static::init($ini)->extend($ini, $descs, $scope);
    }

    public static function buildWithItsName(Ini $ini, string $name, string $descs, $scope = null): self
    {
        return self::initWithItsName($ini, $name)->extend($ini, $descs, $scope);
    }

    public function __construct(Ini $ini)
    {
        //$this->initialize($ini);
    }

    public function extend(Ini $ini, string $descs, $scope = null): self
    {
        return array_reduce($this->split($descs), function ($carry, $desc) use ($ini, $scope) {
            [$name, $args] = $carry->parse($desc);
            $carry->add(BaseRelationship::buildWithItsName($ini, $name, $args, $scope));
            return $carry;
        }, $this);
    }

    protected function split(string $descs): array
    {
        return preg_split("/\|{2}/", $descs);
    }

    protected function parse(string $desc): array
    {
        return preg_split("/:{2}/", $desc);
    }

    public function add(self|BaseRelationship $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseRelationship $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function getRelationalProposals(string $planName): array
    {
        return array_reduce($this->items, function ($carry, $rel) use ($planName) {
            return array_merge($carry, $rel->getRelationalProposals($planName));
        }, []);
    }
}