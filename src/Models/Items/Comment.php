<?php

namespace Erupt\Models\Items;

use Erupt\Models\BaseModel;

class Comment extends BaseModel
{
    public function getName(): string
    {
        return "comment";
    }
}