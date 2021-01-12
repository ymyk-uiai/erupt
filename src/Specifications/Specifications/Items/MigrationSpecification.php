<?php

namespace Erupt\Specifications\Specifications\Items;

use Erupt\Specifications\Specifications\Bases\BaseSpecification;

class MigrationSpecification extends BaseSpecification
{
    protected string $table_name;

    protected string $command;

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
}