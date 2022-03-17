<?php

namespace Erupt\Files\Items\LaravelPhpClass;

use Erupt\Files\BasePhpClass;
use Erupt\Components\Items\LaravelPhpClass\Controller\Component;
use Erupt\Components\BaseComponent;

class Controller extends BasePhpClass
{
    protected function makeClassName($fileMaker): string
    {
        return "Application\\Http\\Controllers\\" . $fileMaker->getClassSymbol();
    }

    protected function makeShortName($fileMaker): string
    {
        return $fileMaker->getClassSymbol();
    }

    protected function makeNamespace($fileMaker): string
    {
        return "Application\\Http\\Controllers";
    }

    protected function makePath($fileMaker): string
    {
        return "app/Http/Controllers";
    }

    protected function makeFileName($fileMaker): string
    {
        return "app/Http/Controllers/" . $fileMaker->getClassSymbol() . ".php";
    }

    protected function compileComponent(): BaseComponent
    {
        return Component::compile();
    }
}