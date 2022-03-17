<?php

namespace Erupt\Components\Items\LaravelPhpClass\Controller;

use Erupt\Components\BasePhpClass;
use Erupt\Components\Items\LaravelPhpMethod as Method;

class Component extends BasePhpClass
{
    public function __construct()
    {
        $this->template = file_get_contents(__DIR__.'/template.txt');
    }

    protected array $components = [
        "@nested1" => Method\Index\Component::class,
        "@nested2" => Method\Index\Component::class,
    ];
}