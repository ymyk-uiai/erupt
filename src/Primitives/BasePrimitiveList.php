<?php

namespace Erupt\Primitives;

use Erupt\Foundation\BaseList;
use Erupt\Plans\BasePlan;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;

abstract class BasePrimitiveList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

        public static function getClassSymbol(): string
        {
            return array_slice(explode('\\', static::class), 3);
        }
    
        public static function getDefaultClassSymbol(): string
        {
            return "PrimitiveList";
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
            return "Erupt\\Primitives\\Lists\\".ucfirst($className);
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
                $carry->add(BasePrimitive::buildWithItsName($ini, ucfirst($name), $args, $scope));
                return $carry;
            }, $this);
        }
    
        protected function split(string $descs): array
        {
            return preg_split("/\|{1}/", $descs);
        }
    
        protected function parse(string $desc): array
        {
            return preg_split("/:{1}/", $desc);
        }

    public function add(self|BasePrimitive $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BasePrimitive $incoming): void
    {
        $this->removeItemOrList($incoming);
    }

    public function checkRelation(string $planName): array
    {
        $rels = [];
        foreach($this->items as $item) {
            if($item->getClassSymbol() == ucfirst($planName)) {
                $rels[] = $item->getArg('relation');
            }
        }
        return array_unique($rels);
    }

    public function duplicate(): self
    {
        //  static::init($this->makeIni())->add($this);
        $duplicated = static::init($this->makeIni());
        $duplicated->add($this);
        return $duplicated;
    }

    public function filter(string $key): self
    {
        $this->items = array_filter($this->items, function ($item) use ($key) {
            return $item->getArg('relation') == $key;
        });
        return $this;
    }

    public function getString(string $rel): string
    {
        return $this->duplicate()->filter($rel)."";
    }

    public function __toString(): string
    {
        return implode('&', $this->items);
    }
}