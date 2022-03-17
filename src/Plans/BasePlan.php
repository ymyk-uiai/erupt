<?php

namespace Erupt\Plans;

use Erupt\Foundation\BaseListItem;
use Erupt\Proposals\BaseProposalList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BasePlan extends BaseListItem implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected BaseProposalList $proposals;

    protected static array $accessKeys = ['pl', 'plan'];

    public static function getClassSymbol(): string
    {
        return implode('\\', array_slice(explode('\\', static::class), 3));
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
        return "Erupt\\Plans\\Items\\".ucfirst($className);
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
        $this->proposals = BaseProposalList::buildWithItsName($ini, BaseProposalList::getDefaultClassSymbol(), $desc, $scope);
        return $this;
    }

    protected function split(string $descs): array
    {
        return preg_split("/\|{3}/", $descs);
    }

    protected function parse(string $desc): array
    {
        return preg_split("/:{3}/", $desc);
    }

    public function getProposals(): BaseProposalList
    {
        return $this->proposals;
    }
}