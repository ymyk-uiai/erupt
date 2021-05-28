<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Folder extends BaseModel
{
    public function getType(): string
    {
        return "folder";
    }
}