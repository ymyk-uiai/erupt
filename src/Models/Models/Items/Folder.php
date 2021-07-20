<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Folder extends BaseModel
{
    static protected array $defaultAttributes = [
        "name" => "resource",
        "email" => "unique",
    ];

    static protected array $defaultRelationalAttributes = [
        "user" => "required",
        "comment" => "interactive",
    ];

    public function getType(): string
    {
        return "folder";
    }
}