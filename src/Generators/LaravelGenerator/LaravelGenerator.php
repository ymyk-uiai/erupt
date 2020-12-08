<?php

namespace Erupt\Generators\LaravelGenerator;

use Erupt\Models\Files\LaravelFile;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Generators\BaseGenerator;

class LaravelGenerator extends BaseGenerator
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
            "factory" => "database\\factories",
            "seeder" => "database\\seeders"
        ];
    }

    public function getAuthCommandKeys()
    {
        return [
            "model",
            "policy",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
        ];
    }

    public function getContentCommandKeys()
    {
        return [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
        ];
    }

    public function getBinderCommandKeys()
    {
        return [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
        ];
    }

    public function getResponseCommandKeys()
    {
        return [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
        ];
    }

    protected function getAllCommands()
    {
        return [
            "model" => [
                "command" => "model",
            ],
            "policy" => [
                "command" => "policy",
                "name" => "@Policy",
            ],
            "request/store" => [
                "command" => "request",
                "name" => "@StoreRequest",
                "variant" => "store",
            ],
            "request/update" => [
                "command" => "request",
                "name" => "@UpdateRequest",
                "variant" => "update",
            ],
            "resource" => [
                "command" => "resource",
                "useAs" => "@Resource",
            ],
            "resource/collection" => [
                "command" => "collection",
                "name" => "@Collection",
            ],
            "controller" => [
                "command" => "controller",
                "name" => "@Controller",
            ],
            "factory" => [
                "command" => "factory",
                "name" => "@Factory",
            ],
            "seeder" => [
                "command" => "seeder",
                "name" => "@Seeder",
            ],
            "component/card" => [
                "command" => "component",
                "name" => "Card",
            ],
            "component/form" => [
                "command" => "component",
                "name" => "Form",
            ],
            "page/index" => [
                "command" => "page",
                "name" => "index",
            ],
            "page/create" => [
                "command" => "page",
                "name" => "create",
            ],
            "page/_id/index" => [
                "command" => "page",
                "name" => "_id/index",
            ],
            "page/_id/update" => [
                "command" => "page",
                "name" => "_id/update",
            ],
            "store/index" => [
                "command" => "store",
                "name" => "index",
            ],
            "store/show" => [
                "command" => "store",
                "name" => "show",
            ],
            "store/store" => [
                "command" => "store",
                "name" => "store",
            ],
            "store/update" => [
                "command" => "store",
                "name" => "update",
            ],
            "store/destroy" => [
                "command" => "store",
                "name" => "destroy",
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
        return LaravelFile::class;
    }

    public function getBasePath()
    {
        return __DIR__;
    }

    public function getComponentDirName()
    {
        return "components";
    }
}