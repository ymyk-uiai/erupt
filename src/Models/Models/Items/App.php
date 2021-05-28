<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class App extends BaseModel
{
    public function getType(): string
    {
        return "app";
    }
}