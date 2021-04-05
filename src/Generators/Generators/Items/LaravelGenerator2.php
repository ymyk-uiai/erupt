<?php

namespace Erupt\Generators\Generators\Items;

use Erupt\Generators\Generators\BaseGenerator;

class LaravelGenerator2 extends BaseGenerator
{
    protected static array $file_spec_models = [
        "model" => [
            "class_name" => [
                "namespace:body" => "Models",
                "short_name" => "{Name}",
            ],
            "template_path:name:body" => "model",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "policy" => [
            "class_name" => [
                "namespace:body" => "Policies",
                "short_name" => "{Name}Policy",
            ],
            "template_path:name:body" => "policy",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "request" => [
            "class_name" => [
                "namespace:body" => "Http\\Requests",
                "short_name" => "{Name}{Variant}Request",
            ],
            "template_path:name:body" => "request",
            "makers" => [
                "auth:update",
                "content:store,update",
                "binder:store,update",
                "response:store,update",
            ],
        ],
        "resource" => [
            "class_name" => [
                "namespace:body" => "Http\\Resources",
                "short_name" => "{Name}",
            ],
            "template_path:name:body" => "request",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "collection" => [
            "class_name" => [
                "namespace:body" => "Http\\Resources",
                "short_name" => "{Name}Collection",
            ],
            "template_path:name:body" => "collection",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "controller" => [
            "class_name" => [
                "namespace:body" => "Http\\Controllers",
                "short_name" => "{Name}Controller",
            ],
            "template_path:name:body" => "controller",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "factory" => [
            "class_name" => [
                "namespace:body" => "Factories",
                "short_name" => "{Name}Factory",
            ],
            "template_path:name:body" => "factory",
            "output_path:dir" => "database/factories",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "seeder" => [
            "class_name" => [
                "namespace" => "Database\\Seeders",
                "short_name" => "{Name}sTableSeeder",
            ],
            "template_path:name:body" => "seeder",
            "output_path:dir" => "database/factories",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "blade_component_class" => [
            "class_name" => [
                "namespace:body" => "View\\Components",
                "short_name" => "{Name}{Variant}",
            ],
            "template_path:name:body" => "{variant}",
            "makers" => [
                "auth:full,heading,update,button",
                "content:full,heading,store,update,button",
                "binder:full,heading,store,update,button",
                "response:full,heading,store,update,button",
            ],
        ],
        "blade_component_template" => [
            "output_type" => "blade",
            "template_path" => [
                "dir:body" => "models/blade",
                "name:body" => "{variant}",
            ],
            "output_path:dir:body" => "components/{name}",
            "makers" => [
                "auth:full,heading,update,button",
                "content:full,heading,store,update,button",
                "binder:full,heading,store,update,button",
                "response:full,heading,store,update,button",
            ],
        ],
        "blade_page" => [
            "output_type" => "blade",
            "template_path" => [
                "dir:body" => "models/blade",
                "name:body" => "{variant}",
            ],
            "output_path:dir:body" => "{name}s",
            "makers" => [
                "auth:index,show,edit",
                "content:index,create,show,edit",
                "binder:index,create,show,edit",
                "response:index,create,show,edit",
            ],
        ],
        "blade_layout" => [
            "output_type" => "blade",
            "template_path" => [
                "dir:body" => "models/blade",
                "name:body" => "{variant}",
            ],
            "output_path:dir:body" => "layouts",
            "makers" => [
                "app:navigation",
            ],
        ],
        "blade_base_page" => [
            "output_type" => "blade",
            "template_path" => [
                "dir:body" => "models/blade",
                "name:body" => "{variant}",
            ],
            "makers" => [
                "app:welcome,dashboard",
            ],
        ],
    ];

    protected static array $required_values = [
        "common" => [
            "model_name",
            "model_type",
            "template_name",
            "makers",
        ],
        "php" => [
            //
        ],
        "blade" => [
            //
        ],
    ];

    protected static array $default_values = [];

    /*
     * model_name
     * model_path
     * 
     * spec_key
     * spec_variant
     * resolve_key
     * base_class_name
     * class_name
     * namespace
     * file_type
     * 
     * class_name
     *   namespace
     *     base
     *     body
     *   short_name
     * 
     * template_path
     *   dir
     *     base
     *     body
     *   name
     *     prefix
     *     body
     *     suffix
     *     extension
     * 
     * output_path
     *   dir
     *     base
     *     body
     *   name
     *     prefix
     *     body
     *     suffix
     *     extention
     */
}