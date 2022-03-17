<?php

namespace Erupt\Files\Items\LaravelPhpClass;

use Erupt\Files\BasePhpClass;
use Erupt\Components\Items\LaravelPhpClass\Model\Component;
use Erupt\Components\BaseComponent;

class Model extends BasePhpClass
{
    protected function makeClassName($fileMaker): string
    {
        return "Application\\Models\\" . $fileMaker->getClassSymbol();
    }

    protected function makeShortName($fileMaker): string
    {
        return $fileMaker->getClassSymbol();
    }

    protected function makeNamespace($fileMaker): string
    {
        return "Application\\Models";
    }

    protected function makePath($fileMaker): string
    {
        return "app/Models";
    }

    protected function makeFileName($fileMaker): string
    {
        return "app/Models/" . $fileMaker->getClassSymbol() . ".php";
    }

    protected function compileComponent(): BaseComponent
    {
        return Component::compile();
    }
}