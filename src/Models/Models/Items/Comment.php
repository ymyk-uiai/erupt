<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Comment extends BaseModel
{
    public function getType(): string
    {
        return "comment";
    }
}