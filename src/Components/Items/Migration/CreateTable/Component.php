<?php

namespace Erupt\Components\Items\Migration\CreateTable;

use Erupt\Components\BaseMigration;

class Component extends BaseMigration
{
    public function __construct()
    {
        $this->template = file_get_contents(__DIR__.'/template.txt');
    }

}