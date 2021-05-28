<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Post extends BaseModel
{
    public function getType(): string
    {
        return "post";
    }
}