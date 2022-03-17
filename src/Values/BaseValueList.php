<?php

namespace Erupt\Values;

use Erupt\Foundation\BaseList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Attributes\BaseAttribute;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseValueList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $accessKeys = ['vs', 'values', 'valueList'];

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
        return "Erupt\\Values\\Lists\\".ucfirst($className);
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
        $descs = array_filter(explode('|', $descs));

        foreach($descs as $desc) {
            [$name, $args] = explode(':', $desc.":");
            $this->add(BaseValue::buildWithItsName($ini, $name, $args, $scope));
        }

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

    public function add(self|BaseValue $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseValue $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function access(string $keys, int $index): Accessor
    {
        $key = $this->getNextKey($keys, $index);

        foreach($this->items as $item) {
            if($item->getClassSymbol() == ucfirst($key)) {
                return $item;
            }
        }

        throw new \Exception($keys);
    }
}