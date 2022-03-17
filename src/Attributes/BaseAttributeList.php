<?php

namespace Erupt\Attributes;

use Erupt\Foundation\BaseList;
use Erupt\Attributes\Containers\AttributeContainer;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;

abstract class BaseAttributeList extends BaseList implements Accessor
{
    use HandleInitialize,
        HandleAccess;

        public static function getClassSymbol(): string
        {
            return implode('\\', array_slice(explode('\\', static::class), 3));
        }
    
        public static function getDefaultClassSymbol(): string
        {
            return "AttributeList";
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
            return "Erupt\\Attributes\\Lists\\".ucfirst($className);
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
                $carry->add(BaseAttribute::buildWithItsName($ini, $name, $args, $scope));
                return $carry;
            }, $this);
        }
    
        protected function split(string $descs): array
        {
            return preg_split("/\|/", $descs);
        }
    
        protected function parse(string $desc): array
        {
            return preg_split("/:/", $desc.":");
        }
    
    public static function wrap(Ini $ini, BaseAttribute $incoming): static
    {
        //  static::init($ini)->add($incoming);
        $list = static::init($ini);
        $list->add($incoming);
        return $list;
    }

    public function add(self|BaseAttribute $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseAttribute $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function isTableColumnMaker(): bool
    {
        foreach($this as $item) {
            if($item->isTableColumnMaker()) {
                return true;
            }
        }
        return false;
    }

    public function evaluate(): BaseAttributeContainer
    {
        return array_reduce($this->items, function ($carry, $item) {
            $carry->add($item->evaluate());
            return $carry;
        }, AttributeContainer::init($this->makeIni()));
    }
}