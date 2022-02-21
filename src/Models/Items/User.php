<?php

namespace Erupt\Models\Items;

use Erupt\Models\BaseModel;

class User extends BaseModel
{
    public function getName(): string
    {
        return "user";
    }
}