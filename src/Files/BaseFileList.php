<?php

namespace Erupt\Files;

use Erupt\Foundation\BaseList;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Application as A;
use Erupt\Plans\Lists\PlanList as P;
use Erupt\Relationships\Lists\RelationshipList as R;
use Erupt\Plans\Items\{User, Post, Folder, Comment};
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;

abstract class BaseFileList extends BaseList implements Accessor
{
    use HandleAccess,
        HandleInitialize;

    protected static array $files = [
        Items\Migration\CreateTable::class => [
            Post::class,
            Folder::class,
            Comment::class,
        ],
        Items\LaravelPhpClass\Model::class => [
            User::class,
            Post::class,
            Folder::class,
            Comment::class,
        ],
        Items\LaravelPhpClass\Controller::class => [
            User::class,
            Post::class,
            Folder::class,
            Comment::class,
        ],
    ];
    
    public static function init(Ini $ini, string $name = null): self
    {
        return empty($name) ? new static($ini) : self::instantiate($ini, self::makeClassName($name));
    }

    protected static function makeClassName(string $className): string
    {
        return "Erupt\\Files\\Lists\\".ucfirst($className);
    }

    protected static function instantiate(Ini $ini, string $className): self
    {
        return class_exists($className) ? new $className($ini) : throw new \Exception($className);
    }

    public static function buildFileList(Ini $ini, string $descs, $scope = null): self
    {
        return static::init($ini)->build($ini, $descs, $scope);
    }

    public function __construct(Ini $ini)
    {
        $this->initialize($ini);
    }

    public static function build(Ini $ini, P $plans, R $relationships): static
    {
        $files = new static($ini);

        $files->make($ini, $plans, $relationships);

        return $files;
    }

    public function make(Ini $ini, P $plans, R $relationships): void
    {
        foreach($plans as $plan) {
            $className = get_class($plan);
            foreach(self::$files as $fileClass => $candidates) {
                if(in_array($className, $candidates)) {
                    $this->add($fileClass::build($ini, $plan));
                }
            }
        }
    }

    public function add(self|BaseFile $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(self|BaseFile $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}