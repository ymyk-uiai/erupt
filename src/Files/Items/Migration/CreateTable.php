<?php

namespace Erupt\Files\Items\Migration;

use Erupt\Files\BaseMigration;
use Erupt\Components\Items\Migration\CreateTable\Component;
use Erupt\Components\BaseComponent;

class CreateTable extends BaseMigration
{
    protected function makeTableName($fileMaker): string
    {
        return "create_" . lcfirst($fileMaker->getClassSymbol()) . "s_table";
    }

    protected function makeClassName($fileMaker): string
    {
        return "";
    }

    protected function makeShortName($fileMaker): string
    {
        return lcfirst($fileMaker->getClassSymbol());
    }

    protected function makeNamespace($fileMaker): string
    {
        return "";
    }

    protected function makePath($fileMaker): string
    {
        return "database/migrations";
    }

    protected function makeFileName($fileMaker): string
    {
        return "test";
    }

    protected function compileComponent(): BaseComponent
    {
        return Component::compile();
    }
}