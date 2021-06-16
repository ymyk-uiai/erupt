<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Comment extends BaseModel
{
    static protected array $defaultAttributes = [
        "name" => "resource",
        "email" => "unique",
    ];

    public function getType(): string
    {
        return "comment";
    }
}