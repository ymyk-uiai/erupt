<?php

namespace Erupt\Generators\Generators\Items;

use Erupt\Models\Files\LaravelFile;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Generators\Generators\BaseGenerator;
use Erupt\Specifications\Specifications\Items\MigrationSpecification;
use Erupt\Specifications\Specifications\Items\FileSpecification;
use Erupt\Specifications\Specifications\Lists\SpecificationList;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Erupt\Specifications\Specifications\Lists\MigrationSpecificationList;
use Erupt\Interfaces\Makers\Items\MigrationMaker;
use Erupt\Interfaces\Makers\Items\FileMaker;

class LaravelGenerator extends BaseGenerator
{
    protected static string $base_namespace = "Application";

    //  makers => corresponding
    protected static array $file_models = [
        "model" => [
            "file_type" => "php_class",
            "template" => "model",
            "class_name" => "{Name}",
            "namespace" => "Models",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "policy" => [
            "file_type" => "php_class",
            "template" => "policy",
            "class_name" => "{Name}Policy",
            "namespace" => "Policies",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "request" => [
            "file_type" => "php_class",
            "template" => "request",
            "class_name" => "{Name}{Variant}Request",
            "namespace" => "Http\\Requests",
            "makers" => [
                "auth:+update",
                "content:+store,+update",
                "binder:+store,+update",
                "response:+store,+update",
            ],
        ],
        "resource" => [
            "file_type" => "php_class",
            "template" => "{variant}",
            "class_name" => "{Name}{Variant<collection>}",
            "namespace" => "Http\\Resources",
            "makers" => [
                "auth:resource,collection",
                "content:resource,collection",
                "binder:resource,collection",
                "response:resource,collection",
            ]
        ],
        "controller" => [
            "file_type" => "php_class",
            "template" => "controller",
            "class_name" => "{Name}Controller",
            "namespace" => "Http\\Controllers",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "factory" => [
            "file_type" => "php_class",
            "template" => "factory",
            "class_name" => "{Name}Factory",
            "namespace" => "Factories",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "seeder" => [
            "file_type" => "php_class",
            "template" => "seeder",
            "class_name" => "{Name}sTableSeeder",
            "namespace" => "Seeds",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
    ];

    protected static array $migration_models = [];

    public function make_file_specs(FileMaker $maker): FileSpecificationList
    {
        $file_specs = new FileSpecificationList;

        foreach(Self::$file_models as $file_model) {
            $file_model["namespace"] = Self::add_base_namespace($file_model["namespace"]);
            $file_model["template_base_path"] = __DIR__;
            $file_model["variant"] = "";
            $file_model["generator_name"] = Self::class;
            foreach($file_model["makers"] as $maker_cand) {
                if(strpos($maker_cand, $maker->get_model_type()) === 0) {
                    if(strpos($maker_cand, ':') === false) {
                        $file_model["template_key"] = $file_model["template"];
                        $file_specs->add($this->make_file_spec($file_model, $maker));
                    } else {
                        $variants = $this->get_variants_in_arr($maker_cand);
                        foreach($variants as $variant) {
                            if(strpos($variant, '+') === 0) {
                                $variant = trim($variant, '+');
                                $file_model["template_key"] = "{$file_model['template']}@{$variant}";
                            } else {
                                $file_model["template_key"] = $variant;
                            }
                            $file_model["variant"] = $variant;
                            $file_specs->add($this->make_file_spec($file_model, $maker));
                        }
                    }
                }
            }
        }

        return $file_specs;
    }

    protected function add_base_namespace($namespace): string
    {
        return trim(Self::$base_namespace, "/\\") . "\\" . trim($namespace, "/\\");
    }

    protected function get_variants_in_arr($file_cand): array
    {
        $variants_in_str = explode(':', $file_cand)[1];

        return explode(',', $variants_in_str);
    }

    protected function make_file_spec($file_model, $maker)
    {
        return FileSpecification::build($file_model, $maker);
    }


    public function make_migration_specs(MigrationMaker $maker)
    {
        $migration_specs = new MigrationSpecificationList;

        foreach(Self::$migration_models as $migration_model) {
            foreach($migration_model["makers"] as $maker_cand) {
                if(strpos($maker_cand, $maker->get_name()) >= 0) {
                    if(strpos($maker_cand, ':') >= 0) {
                        $file_specs->add($this->make_file_spec($file_model, $maker));
                    } else {
                        $variants = $this->get_variants_in_str($maker_cand);
                        foreach($variants as $variant) {
                            $file_model["variant"] = $variant;
                            $file_specs->add($this->make_file_spec($file_model, $maker));
                        }
                    }
                }
            }
        }

        return $migration_specs;
    }
}