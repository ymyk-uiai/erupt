<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class User extends BaseModel
{
    public function getType(): string
    {
        return "user";
    }
}