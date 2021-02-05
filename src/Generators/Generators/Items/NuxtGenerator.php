<?php

namespace Erupt\Generators\Generators\Items;

use Erupt\Models\Files\LaravelFile;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Generators\Generators\BaseGenerator;
use Erupt\Specifications\Specifications\Items\MigrationSpecification;
use Erupt\Specifications\Specifications\Items\FileSpecification;
use Erupt\Specifications\Specifications\Lists\SpecificationList;
use Erupt\Interfaces\MigrationMaker;
use Erupt\Interfaces\FileMaker;

class NuxtGenerator extends BaseGenerator
{
    protected function getNamespaces()
    {
        return [
            "model" => "Models",
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
        /*
         * "model" => [
         *      "command" => "model",
         *      "included_by" => ["auth"],
         *      "excluded_by" => ["auth"],
         * ]
        */
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
                "use_as" => "@Resource",
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
                "name" => "@TableSeeder",
            ],
            "migration" => [
                "command" => "migration",
                "name" => "@Migration",
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
            "class_name",
            "namespace",
            "fullClassName",
            "use_as",
            "full_use_as",
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

    public function make_file_specifications(FileMaker $maker): SpecificationList
    {
        $spec_list = new SpecificationList;

        $commandSeedKeys = $maker->getCommandSeedKeys();

        // foreach($this->generators as $generator) { ... }

        $name = ucfirst($maker->getName());
        
        $commands = $this->getCommandSeeds($commandSeedKeys, $name);

        foreach($commands as $command) {
            $spec = FileSpecification::build($command);

            $spec_list->add($spec);
        }

        return $spec_list;
    }

    public function make_migration_specifications(MigrationMaker $maker)
    {
        $table_name = $maker->get_table_name();

        $command = $maker->get_command();

        $spec = new MigrationSpecification;

        $spec->set_table_name($table_name);

        $spec->set_command($command);

        return $spec;
    }
}