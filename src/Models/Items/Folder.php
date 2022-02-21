<?php

namespace Erupt\Models\Items;

use Erupt\Models\BaseModel;

class Folder extends BaseModel
{
    public function getName(): string
    {
        return "folder";
    }
}