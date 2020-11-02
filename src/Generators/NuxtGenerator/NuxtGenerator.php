<?php

namespace Erupt\Generators\NuxtGenerator;

use Erupt\Models\Files\NuxtFile;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Generators\BaseGenerator;

class NuxtGenerator extends BaseGenerator
{
    protected function getNamespaces()
    {
        return [
            "model" => "",
            "policy" => "Policies",
            "request" => "Http\Requests",
            "resource" => "Http\Resources",
            "collection" => "Http\Resources",
            "controller" => "Http\Controllers",
        ];
    }

    public function getAuthCommandKeys()
    {
        return [
            "component/card",
        ];
    }

    public function getContentCommandKeys()
    {
        return [
            "component/card"
        ];
    }

    public function getBinderCommandKeys()
    {
        return [
            "component/card"
        ];
    }

    public function getResponseCommandKeys()
    {
        return [
            "component/card",
        ];
    }

    protected function getAllCommands()
    {
        return [
            "component/card" => [
                "command" => "component",
                "name" => "Card",
                "template" => "card",
                "variant" => "card",
            ],
        ];
    }

    public function getPropNames()
    {
        return [
            "type",
            "variant",
            "className",
            "namespace",
            "fullClassName",
            "useAs",
            "fullUseAs",
            "instance",
            "path",
        ];
    }

    public function getFileClass()
    {
        return NuxtFile::class;
    }

    public function getBasePath()
    {
        return __DIR__;
    }
}