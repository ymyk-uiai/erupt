<?php

namespace Erupt\Generators\Generators\Items;

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
    protected static array $file_spec_models = [
        "model" => [
            "data_sup_class_name" => "Models\\{Name}",
            "template_stem" => "model",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
                ],
            ],
        "policy" => [
            "data_sup_class_name" => "Policies\\{Name}Policy",
            "template_stem" => "policy",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ],
        ],
        "request" => [
            "data_sup_class_name" => "Http\\Requests\\{Name}{Variant}Request",
            "template_stem" => "request",
            "data_resolve_key" => "{key}{variant<*,@>}",
            "makers" => [
                "auth:update",
                "content:store,update",
                "binder:store,update",
                "response:store,update",
            ],
        ],
        "resource" => [
            "data_sup_class_name" => "Http\\Resources\\{Name}{Variant}",
            "template_stem" => "{variant}",
            "data_resolve_key" => "{variant}",
            "makers" => [
                "auth:resource,collection",
                "content:resource,collection",
                "binder:resource,collection",
                "response:resource,collection",
            ]
        ],
        "controller" => [
            "data_sup_class_name" => "Http\\Controllers\\{Name}Controller",
            "template_stem" => "controller",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "factory" => [
            "data_sup_class_name" => "Factories\\{Name}Factory",
            "template_stem" => "factory",
            "output_base_path" => "database",
            "output_sup_path" => "factories",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "seeder" => [
            "data_root_namespace" => "Database",
            "data_sup_class_name" => "Seeders\\{Name}sTableSeeder",
            "template_stem" => "seeder",
            "output_base_path" => "database",
            "output_sup_path" => "seeders",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
        "blade" => [
            "output_type" => "blade",
            "template_stem" => "{variant}",
            "template_sup_path" => "models/blade",
            "output_sup_path" => "{name}s",
            "makers" => [
                "auth:index,show,edit",
                "content:index,create,show,edit",
                "binder:index,create,show,edit",
                "response:index,create,show,edit",
            ],
        ],
        "layout_blade" => [
            "output_type" => "blade",
            "template_stem" => "{variant}",
            "template_sup_path" => "models/blade",
            "output_sup_path" => "layouts",
            "makers" => [
                "app:navigation",
            ],
        ],
        "base_blade" => [
            "output_type" => "blade",
            "template_stem" => "{variant}",
            "template_sup_path" => "models/blade",
            "makers" => [
                "app:welcome,dashboard",
            ],],
    ];

    protected static array $migration_spec_models = [
        "table" => [
            "name" => "table",
            "makers" => [
                "auth",
                "content",
                "binder",
                "response",
            ]
        ],
    ];

    protected static array $default_values = [
        "common" => [
            "output_type" => "php",
            "data_spec_variant" => "",
            "template_base_path" => __DIR__,
            "template_sup_path" => "models/{type}",
            "template_sup_stem" => "",
            "template_extension" => "txt",
            "output_sup_path" => "",
            "generator_class_name" => Self::class,
        ],
        "php" => [
            "data_root_namespace" => "App",
            "data_use_as" => "{Name}{Key}",
            "data_resolve_key" => "{key}{variant<*,@>}",
            "output_base_path" => "app",
            "output_sup_stem" => "",
            "output_extension" => "php",
        ],
        "blade" => [
            "data_resolve_key" => "{key}{variant<*,@>}",
            "output_base_path" => "resources/views",
            "output_sup_stem" => "blade",
            "output_extension" => "php",
        ],
    ];

    protected static array $required_values = [
        "common" => [
            "template_stem",
            "makers",
        ],
        "php" => [
            "data_sup_class_name"
        ],
        "blade" => [],
    ];

    protected static array $preprocessor = [
        "common" => [
            "model_name" => "@",
            "model_type" => "@",
            "data_spec_key" => "@",
            "data_spec_variant" => "@",
            "data_resolve_key" => "@",
            "data_namespace" => "placeholder",
            "data_short_name" => "placeholder",
            "data_class_name" => "placeholder",
            "data_use_as" => "@",
            "output_type" => "@",
            "output_base_path" => "@",
            "output_sup_path" => "@",
            "output_parent_path" => "placeholder",
            "output_stem" => "placeholder",
            "output_sup_stem" => "@",
            "output_extension" => "@",
            "template_base_path" => "@",
            "template_sup_path" => "@",
            "template_parent_path" => "@",
            "template_stem" => "@",
            "template_sup_stem" => "@",
            "template_extension" => "@",
            "generator_class_name" => "@",
        ],
        "php" => [
          "data_class_name" => "(data)implode:\\,<root_namespace>,<sup_class_name>",
          "data_short_name" => "(data)explode_pop:\\,<sup_class_name>",
          "data_namespace" => "(data)implode_explode_pop_implode:\\,<root_namespace>,<sup_class_name>",
          "output_sup_path" => "explode_pop_implode:\\,/,<data_sup_class_name>",
          "output_stem" => "explode_pop:\\,<data_sup_class_name>",
        ],
        "blade" => [
            "output_stem" => "<data_spec_variant>",
        ],
    ];

    protected static array $processor = [
        "common" => [
          "model_name" => "@",
          "model_type" => "@",
          "data_resolve_key" => "@",
          "data_spec_key" => "@",
          "data_spec_variant" => "@",
          "template_base_path" => "@",
          "data_class_name" => "@",
          "data_short_name" => "@",
          "data_namespace" => "@",
          "data_use_as" => "@",
          "template_name" => "(template)trim_implode:.,<stem>,.<sup_stem>.<extension>",
          "template_path" => "(template)trim_implode_a:/,.,<base_path>/<sup_path>,<stem>,.<sup_stem>.<extension>",
          "output_path" => "(output)trim_implode_r:/,.,<base_path>/<sup_path>,<stem>,.<sup_stem>.<extension>",
          "output_name" => "(output)trim_implode:.,<stem>,.<sup_stem>.<extension>",
          "generator_class_name" => "@",
        ],
        "php" => [
          "data_class_name" => "@",
          "data_namespace" => "@",
          "data_use_as" => "@",
        ],
        "blade" => [],
    ];

    protected static array $search = [
        "{name}",
        "{Name}",
        "{type}",
        "{Type}",
        "{variant}",
        "{Variant}",
        "{key}",
        "{Key}",
    ];

    public function make_file_specs(FileMaker $maker): FileSpecificationList
    {
        $file_specs = new FileSpecificationList;

        foreach(Self::$file_spec_models as $spec_key => $spec_value) {
            foreach($spec_value["makers"] as $spec_maker) {
                if(strpos($spec_maker, $maker->get_model_type()) === 0) {
                    if(strpos($spec_maker, ':') === false) {
                        $spec  = $this->finish_spec_model($spec_key, $spec_value, $maker);
                        $file_specs->add($this->make_file_spec($spec, $maker));
                    } else {
                        $variants = $this->get_variants_in_array($spec_maker);
                        foreach($variants as $variant) {
                            $spec_value["data_spec_variant"] = trim($variant);
                            $spec = $this->finish_spec_model($spec_key, $spec_value, $maker);
                            $file_specs->add($this->make_file_spec($spec, $maker));
                        }
                    }
                }
            }
        }

        return $file_specs;
    }

    protected static function make_file_spec(array $file_model, FileMaker $maker): FileSpecification
    {
        return FileSpecification::build($file_model, $maker);
    }

    protected function print_spec(string $message, array $spec, string $model_name, string $spec_key)
    {
        if(array_key_exists("makers", $spec)) {
            unset($spec["makers"]);
        }

        ksort($spec);

        print_r("{$model_name}({$spec_key})\t{$message}\n");

        print_r("{$model['name']}({$spec_key})\t$message\n");
        print_r($spec);
    }
    
    protected function finish_spec_model(string $spec_key, array $spec_value, FileMaker $model): array
    {
        $filled_spec_values = $this->fill_defaults($spec_key, $spec_value, $model);

        $this->check_if_required_values_exist($filled_spec_values);

        unset($filled_spec_values["makers"]);

        $replaced_spec_values = $this->replace($filled_spec_values);

        $preprocessed_spec = $this->process($replaced_spec_values, Self::$preprocessor);

        $processed_spec = $this->process($preprocessed_spec, Self::$processor);

        return $processed_spec;
    }

    protected function replace(array $spec): array
    {
        $replace = $this->make_replace($spec);

        foreach($spec as $spec_key => $spec_value) {
            $spec_value = $this->update_value($spec_value, $spec);

            $spec[$spec_key] = str_replace(Self::$search, $replace, $spec_value);;
        }

        return $spec;
    }

    protected function make_replace($spec): array
    {
        $name = strtolower($spec["model_name"]);
        $type = strtolower($spec["model_type"]);
        $variant = strtolower($spec["data_spec_variant"]);
        $key = strtolower($spec["data_spec_key"]);

        return [
            lcfirst($name),
            ucfirst($name),
            lcfirst($type),
            ucfirst($type),
            lcfirst($variant),
            ucfirst($variant),
            lcfirst($key),
            ucfirst($key),
        ];
    }

    protected function update_value(string $spec_value, array $spec): string
    {
        $pattern = "/{(?P<name>[\w]+)<(?P<variants>(?:[*\w]+)(?:|[\w]+)*)(?:,(?P<prefix>[@\w]+))?>}/";
        
        return preg_replace_callback(
            $pattern,
            function ($matches) use ($spec) {
                $variant = trim($spec["data_spec_variant"]);
                $variants = explode('|', $matches["variants"]);

                if($matches["variants"] == '*' && $variant != "") {
                    $variant_check = true;
                } else if(in_array($variant, $variants)) {
                    $variant_check = true;
                } else {
                    $variant_check = false;
                }
                
                if($variant_check) {
                    return "{$matches['prefix']}{{$matches['name']}}";
                } else {
                    return "";
                }
            },
            $spec_value,
            -1,
            $count,
            PREG_UNMATCHED_AS_NULL
        );
    }

    protected function fill_defaults(string $spec_key, array $spec_value, FileMaker $maker): array
    {
        $spec_value["model_name"] = $maker->get_name();
        $spec_value["model_type"] = $maker->get_model_type();
        $spec_value["data_spec_key"] = $spec_key;

        $output_type = array_key_exists("output_type", $spec_value) ? $spec_value["output_type"] : "php";

        return array_merge(
            Self::$default_values["common"],
            Self::$default_values[$output_type],
            $spec_value
        );
    }

    protected function check_if_required_values_exist(array $spec_value): void
    {
        foreach(Self::$required_values["common"] as $value) {
            if(!array_key_exists($value, $spec_value)) {
                ksort($spec_value);
                throw new \Error("{$value} does not exists.");
            }
        }
        
        if($spec_value["output_type"] == "php") {
            foreach(Self::$required_values["php"] as $value) {
                if(!array_key_exists($value, $spec_value)) {
                    throw new \Error;
                }
            }
        } else if($spec_value["output_type"] == "blade") {
            foreach(Self::$required_values["blade"] as $spec_value) {
                if(!array_key_exists($value, $spec_value)) {
                    throw new \Error;
                }
            }
        } else {
            throw new \Error;
        }
    }

    protected function process(array $spec, array $processor): array
    {
        $p = array_merge(
            $processor["common"],
            $processor[$spec["output_type"]],
            array_filter($spec)
        );

        foreach($p as $k => $v) {
            if(trim($v) == '@') {
                $p[$k] = array_key_exists($k, $spec) ? $spec[$k] : "missing";
            } else {
                $p[$k] = $this->rendar($k, $v, $spec);
            }
        }

        return $p;
    }

    protected function rendar(string $p_key, string $p_value, array $reference): string
    {
        $p_value = $this->inject_value($p_value, $reference);

        $p_value = $this->exec_method($p_value, $p_key);

        return $p_value;
    }

    protected function inject_value(string $subject, array $reference): string
    {
        if(preg_match(
            "/\((?P<namespace>\w+)\)(?P<rest>.+$)/",
            $subject,
            $matches
        ) === 1) {
            $subject = $matches["rest"];
        }
        
        $namespace = array_key_exists("namespace", $matches) ? $matches["namespace"]."_" : "";

        return preg_replace_callback(
            "/<(?P<key>\w+)>/",
            function ($matches) use ($reference, $namespace) {
                $key = "{$namespace}{$matches['key']}";
                return $reference[$key];
            },
            $subject
        );
    }

    protected function exec_method(string $p_value, string $p_key): string
    {
        if(preg_match(
            "/^(?P<method>\w+):(?P<rest>.+)$/",
            $p_value,
            $matches
        ) === 1) {
            $subject = $matches["rest"];
            $method = $matches["method"];

            if($method == "implode") {
                $args = explode(',', $subject);
                return implode(array_shift($args), $args);
            } else if($method == "explode_implode") {
                $args = explode(',', $subject);
                return implode($args[1], explode($args[0], $args[2]));
            } else if($method == "explode_pop") {
                $args = explode(',', $subject);
                $sj = explode($args[0], $args[1]);
                return array_pop($sj);
            } else if($method == "explode_pop_implode") {
                $args = explode(',', $subject);
                $ex_char = array_shift($args);
                $im_char = array_shift($args);
                $sj = array_shift($args);
                $sj = explode($ex_char, $sj);
                array_pop($sj);
                return implode($im_char, $sj);
            } else if($method == "trim_implode") {
                $args = explode(',', $subject);
                $char = array_shift($args);
                $args = array_map(
                    function ($n) use ($char) {
                        return trim($n, $char);
                    },
                    $args
                );
                return implode($char, $args);
            } else if($method == "trim_implode_a") {
                $args = explode(',', $subject);
                $char_1 = array_shift($args);
                $char_2 = array_shift($args);
                $path = array_shift($args);
                $name = $args;
                $name = array_map(
                    function ($n) use ($char_2) {
                        return trim($n, $char_2);
                    },
                    $name
                );
                $name = implode($char_2, $name);

                $path = trim($path, $char_1);
                $name = [$path, $name];
                $result = implode($char_1, $name);
                return "$char_1$result";
            } else if($method == "trim_implode_r") {
                $args = explode(',', $subject);
                $char_1 = array_shift($args);
                $char_2 = array_shift($args);
                $path = array_shift($args);
                $name = $args;
                $name = array_map(
                    function ($n) use ($char_2) {
                        return trim($n, $char_2);
                    },
                    $name
                );
                $name = implode($char_2, $name);

                $path = trim($path, $char_1);
                $name = [$path, $name];
                return implode($char_1, $name);
            } else if($method == "implode_explode_pop_implode") {
                $args = explode(',', $subject);
                $char = array_shift($args);

                $sbj = implode($char, $args);
                $sbj = explode($char, $sbj);
                
                array_pop($sbj);
                
                return implode($char, $sbj);
            } else {
                return $subject;
            }
        } else {
            return $p_value;
        }
    }

    protected function get_variants_in_array(string $variants): array
    {
        return explode(',', explode(':', $variants)[1]);
    }

    public function make_migration_specs(MigrationMaker $maker): MigrationSpecificationList
    {
        $migration_specs = new MigrationSpecificationList;

        foreach(Self::$migration_spec_models as $spec_key => $spec_value) {
            foreach($spec_value["makers"] as $spec_maker) {
                if(strpos($spec_maker, $maker->get_model_type()) === 0) {
                    $migration_specs->add($this->make_migration_spec($spec_value, $maker));
                }
            }
        }
        return $migration_specs;
    }

    protected function make_migration_spec($spec_value, $maker): MigrationSpecification
    {
        return MigrationSpecification::build($spec_value, $maker);
    }
}
