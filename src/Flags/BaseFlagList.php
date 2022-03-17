<?php

namespace Erupt\Flags;

use Erupt\Foundation\BaseList;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseFlagList extends BaseList
{
    use HandleInitialize;


    public static function getClassSymbol(): string
    {
        return array_slice(explode('\\', static::class), 0, 0);
    }

    public static function getDefaultClassSymbol(): string
    {
        return "FlagList";
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
        return "Erupt\\Flags\\Lists\\".ucfirst($className);
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
        //  array_reduce
        $descs = array_filter(explode('|', $descs));

        foreach($descs as $desc) {
            [$name, $args] = explode(':', $desc.":");
            $this->add(BaseFlag::buildWithItsName($ini, $name, $args, $scope));
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

    public function add(self|BaseFlag $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseFlag $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}