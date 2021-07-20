<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Comment extends BaseModel
{
    static protected array $defaultAttributes = [
        "text" => "resource",
    ];

    static protected array $defaultRelationalAttributes = [
        "user" => "required",
        "comment" => "interactive",
    ];

    public function getType(): string
    {
        return "comment";
    }
}