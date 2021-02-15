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
        "{key}",
        "{Key}",
    ];

    protected array $data;

    public static function build($data, $maker): Self
    {
        $product = new Self;

        ksort($data);
        //print_r($data);

        $product->data = $data;

        return $product;
    }

    protected function finish($data, $maker, $my_str): string
    {
        $replaces = $this->make_replace($maker, $data);

        $pattern = "/<(?:[\w]+)(?:|[\w]+)*>/";

        if(preg_match($pattern, $my_str, $matches) === 0) {
            return str_replace(Self::$search, $replaces, $my_str);
        } else {
            $pattern = "/{\w+<(?:[\w]+)(?:|[\w]+)*>}/";
            if(strpos($matches[0], $data["variant"]) >= 0) {
                $my_str = str_replace($matches[0], "", $my_str);
                return str_replace(Self::$search, $replaces, $my_str);
            } else {
                $my_str = preg_replace($pattern, "", $my_str);
                return str_replace(Self::$search, $replaces, $my_str);
            }
        }
    }

    protected function init_matches($matches)
    {
        $named_subpatterns = [
            "name" => 0,
            "variants" => "",
            "pre" => "",
        ];

        foreach($named_subpatterns as $key => $value) {
            if(!array_key_exists($key, $matches)) {
                $matches[$key] = $value;
            }
        }

        return $matches;
    }

    protected function right(string $my_str): string
    {
        return match(true) {
            strpos($my_str, '/') !== false => implode('/', array_slice(explode('/', $my_str), -1)),
            strpos($my_str, '\\') !== false => implode('\\', array_slice(explode('\\', $my_str), -1)),
            default => $my_str,
        };
    }

    protected function rm_right(string $my_str): string
    {
        return match(true) {
            strpos($my_str, '/') !== false => implode('/', array_slice(explode('/', $my_str), 0, -1)),
            strpos($my_str, '\\') !== false => implode('\\', array_slice(explode('\\', $my_str), 0, -1)),
            default => $my_str,
        };
    }

    protected function make_replace($maker, $model): array
    {
        $name = strtolower($maker->get_name());
        $variant = strtolower($model["variant"]);
        $key = strtolower($model["key"]);

        return [
            lcfirst($name),
            ucfirst($name),
            lcfirst($variant),
            ucfirst($variant),
            lcfirst($key),
            ucfirst($key),
        ];
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

    public function get_model_name(): string
    {
        return $this->data["model_name"];
    }
    
    public function get_model_type(): string
    {
        return $this->data["model_type"];
    }

    public function get_template_name(): string
    {
        return $this->data["template_name"];
    }

    public function get_template_key(): string
    {
        return $this->data["data_resolve_key"];
    }

    public function get_args_and_options($template, $result): array
    {
        return [
            "model" => [
                "name" => $this->data["model_name"],
                "type" => $this->data["model_type"],
            ],
            "--data" => [
                "resolve_key" => $this->data["data_resolve_key"],
                "short_name" => $this->data["data_short_name"],
                "class_name" => $this->data["data_class_name"],
                "namespace" => $this->data["data_namespace"],
            ],
            "--file" => [
                "name" => $this->data["output_name"],
                "path" => $this->data["output_path"],
            ],
            "--template" => [
                "name" => $this->data["template_name"],
                "path" => $this->data["template_path"],
                "base_path" => $this->data["template_base_path"],
            ],
            "--generator" => [
                "class_name" => $this->data["generator_class_name"],
            ],
            "--io_template" => $template,
            "--io_result" => $result,
        ];
    }

    public function resolve($keys)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        $values = [
            "short_name" => $this->data["data_short_name"],
            "class_name" => $this->data["data_class_name"],
            "namespace" => $this->data["data_namespace"],
            "use_as" => $this->data["data_use_as"],
            "full_use_as" => $this->data["data_class_name"],
            "instance" => $this->data["model_name"],
            "instances" => $this->data["model_name"]."s",
        ];

        return $values[$key];
    }
}