<?php

namespace Erupt\Generators\Items\Laravel;

use Erupt\Generators\BaseGenerator;
use Erupt\Plans\Items\User;
use Erupt\Plans\Items\Post;
use Erupt\Plans\Items\Comment;
use Erupt\Plans\Items\Folder;
use Erupt\Relationships\Items\MorphOneToMany;
use Erupt\Interfaces\Migrator;
use Erupt\Migrations\Items\Migration;
use Erupt\Migrations\BaseMigration;

class MigrationGenerator extends BaseGenerator
{
    protected bool $migration = true;

    protected array $targets = [
        Post::class,
        Comment::class,
        Folder::class,
    ];

    public function generate(Migrator $migrator): BaseMigration
    {
        $product = new Migration;

        $product->setCommand($migrator->getCommand());

        $product->setStatements($migrator->getStatements());

        return $product;
    }
}