<?php

namespace Erupt\Specifications\Specifications\Items;

use Erupt\Specifications\Specifications\BaseSpecification;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Interfaces\SchemaModifier;

class MigrationSpecification extends BaseSpecification
{
    protected string $table_name;

    protected string $command;

    protected string $modelType;

    protected array $stmts = [];

    public static function build($data, $maker, $plans): Self
    {
        $product = new Self;

        ksort($data);
        //print_r($data);

        $table = $maker->getType();

        $product->modelType = $maker->getType();

        //$product->maker = $maker;

        $product->command = "create_{$table}s_table";

        foreach($plans as $plan) {
            if($plan->getType() == $maker->getType()) {
                foreach($plan->getProperties() as $prop) {
                    $stmt = ["\$table"];
                    if(!$prop->getAttributes()->isCommandStrict()) {
                        continue;
                    }
                    foreach($prop->getAttributes() as $attribute) {
                        if($attribute instanceof SchemaCommand || $attribute instanceof SchemaModifier) {
                            $stmt[] = "${attribute}";
                        }
                    }
                    $product->stmts[] = implode("->", $stmt);
                }
            }
        }

        return $product;
    }

    public function get_model_type(): string
    {
        return $this->modelType;
    }

    public function set_table_name(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function get_table_name(): string
    {
        return $this->table_name;
    }

    public function set_command(string $command)
    {
        $this->command = $command;
    }

    public function get_command(): string
    {
        return $this->command;
    }

    public function get_migration(): string
    {
        return implode(";\n", $this->stmts);
    }

    public function get_args_and_options($t, $r): array
    {
        return [];
    }
}