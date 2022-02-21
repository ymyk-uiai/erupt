<?php

namespace Erupt\Interfaces;

interface Migrator
{
    public function getCommand(): string;

    public function getStatements(): array;
}