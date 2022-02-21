<?php

namespace Erupt\Models\Items;

use Erupt\Models\BaseModel;

class Post extends BaseModel
{
    public function getName(): string
    {
        return "post";
    }
}