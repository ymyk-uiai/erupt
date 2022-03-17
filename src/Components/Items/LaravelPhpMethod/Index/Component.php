<?php

namespace Erupt\Components\Items\LaravelPhpMethod\Index;

use Erupt\Components\BasePhpMethod;

class Component extends BasePhpMethod
{
    public function __construct()
    {
        $this->template = file_get_contents(__DIR__.'/template.txt');
    }

}