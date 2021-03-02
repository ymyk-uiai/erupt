<?php

namespace Erupt\Specifications\Specifications\Items;

use Erupt\Specifications\Specifications\BaseSpecification;

class MigrationSpecification extends BaseSpecification
{
    protected string $table_name;

    protected string $command;

    public static function build($data, $maker): Self
    {
        $product = new Self;

        ksort($data);
        //print_r($data);

        $table = $maker->get_name();

        $product->maker = $maker;

        $product->command = "create_{$table}s_table";

        return $product;
    }

    public function get_model_type(): string
    {
        return $this->maker->get_type();
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
        return $this->maker->get_migration();
    }

    public function get_args_and_options($t, $r): array
    {
        return [];
    }
}