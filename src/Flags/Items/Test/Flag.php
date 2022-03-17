<?php

namespace Erupt\Flags\Items\Test;

use Erupt\Flags\BaseFlag;

class Flag extends BaseFlag
{
    protected ?string $params = "bool";

    public function __construct()
    {
        //
    }
}