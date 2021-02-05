<?php

namespace Erupt\Specifications\Specifications\Items;

use Erupt\Specifications\Specifications\BaseSpecification;

class FileSpecification extends BaseSpecification
{
    protected static array $search = [
        "{name}",
        "{Name}",
        "{variant}",
        "{Variant}",
    ];

    protected string $model_name;

    protected string $model_type;

    protected string $file_type;

    protected string $file_class_name;

    protected string $file_namespace;

    protected string $file_path;

    protected string $template_name;

    protected string $template_base_path;

    protected string $template_key;

    protected string $generator_name;

    public static function build($file_model, $maker): Self
    {
        $product = new Self;

        $product->model_name = $maker->get_name();

        $product->model_type = $maker->get_model_type();

        $product->file_type = Self::replace($maker, $file_model, $file_model["file_type"]);

        $product->file_class_name = Self::replace($maker, $file_model, $file_model["class_name"]);

        $product->file_namespace = Self::replace($maker, $file_model, $file_model["namespace"]);

        $product->file_path = Self::make_file_path($product);

        $product->template_name = Self::replace($maker, $file_model, $file_model["template"]);

        $product->template_base_path = $file_model["template_base_path"];

        $product->template_key = $file_model["template_key"];

        $product->generator_name = $file_model["generator_name"];

        return $product;
    }

    protected static function replace($maker, $file_model, $subject): string
    {
        $subject = Self::update_subject($file_model, $subject);

        $replace = Self::make_replace($maker, $file_model);

        return str_replace(Self::$search, $replace, $subject);
    }

    protected static function update_subject($file_model, $subject): string
    {
        $pattern = "/<(?:[\w]+)(?:,[\w]+)*>/";

        if(preg_match($pattern, $subject, $matches) === 0) {
            return $subject;
        } else {
            $variant = Self::get_variant($file_model);
            $pattern = "/{\w+<(?:[\w]+)(?:,[\w]+)*>}/";
            if(strpos($matches[0], $variant) >= 0) {
                return str_replace($matches[0], "", $subject);
            } else {
                return preg_replace($pattern, "", $subject);
            }
        }
    }

    protected static function get_variant($file_model): string
    {
        return array_key_exists("variant", $file_model) ? $file_model["variant"] : "";
    }

    protected static function make_replace($maker, $model): array
    {
        $name = strtolower($maker->get_name());
        $variant = strtolower(array_key_exists("variant", $model) ? $model["variant"] : "");

        return [
            lcfirst($name),
            ucfirst($name),
            lcfirst($variant),
            ucfirst($variant),
        ];
    }

    protected static function make_file_path($spec): string
    {
        return str_replace(
            [
                "Application",
                "\\",
            ],
            [
                "app",
                "/"
            ],
            $spec->file_namespace
        );
    }
    
    public function get_model_name(): string
    {
        return $this->model_name;
    }
    
    public function get_model_type(): string
    {
        return $this->model_type;
    }

    public function get_template_name(): string
    {
        return $this->template_name;
    }

    public function get_template_key(): string
    {
        return $this->template_key;
    }

    public function get_args_and_options(): array
    {
        return [
            "model" => [
                "name" => $this->model_name,
                "type" => $this->model_type,
            ],
            "--file" => [
                "type" => $this->file_type,
                "class_name" => $this->file_class_name,
                "namespace" => $this->file_namespace,
                "path" => $this->file_path,
            ],
            "--template" => [
                "name" => $this->template_name,
                "base_path" => $this->template_base_path,
                "key" => $this->template_key,
            ],
            "--generator" => [
                "name" => $this->generator_name,
            ]
        ];
    }

    public function resolve($keys)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        $values = [
            "class_name" => $this->file_class_name,
            "fullClassName" => "{$this->file_namespace}\\{$this->file_class_name}",
            "full_class_name" => "{$this->file_namespace}\\{$this->file_class_name}",
            "namespace" => $this->file_namespace,
            "instance" => lcfirst($this->model_name),
            "full_use_as" => "{$this->file_namespace}\\{$this->file_class_name}",
            "use_as" => "{$this->file_namespace}\\{$this->file_class_name}",
            "instances" => lcfirst($this->model_name)."s",
        ];

        return $values[$key];
    }
}