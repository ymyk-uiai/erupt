<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Post extends BaseModel
{
    static protected array $defaultAttributes = [
        "title" => "userInput",
        "text" => "userInput",
    ];

    static protected array $defaultRelationalAttributes = [
        "user" => "required",
        "comment" => "interactive",
        "folder" => "nullable",
    ];

    public function getType(): string
    {
        return "post";
    }
}