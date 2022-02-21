<?php

namespace Erupt\Migrations\Items;

use Erupt\Migrations\BaseMigration;

class Migration extends BaseMigration
{
    public function getTemplate(): string
    {
        return file_get_contents(__DIR__."/template.txt");
    }
}