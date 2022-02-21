<?php

namespace Erupt\Migrations;

use Erupt\Foundation\BaseListItem;

abstract class BaseMigration extends BaseListItem
{
    protected string $command;

    protected array $stmts;

    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    public function setStatements(array $stmts): void
    {
        $this->stmts = $stmts;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function is(string $fileName): bool
    {
        return strpos($fileName, $this->command);
    }

    public function getContent(): string
    {
        return str_replace("//REPLACE//", implode(";\n", $this->stmts), $this->getTemplate());
    }
}