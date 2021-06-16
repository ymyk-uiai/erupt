<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class User extends BaseModel
{
    static protected array $defaultAttributes = [
        "name" => "userInput|fillable",
        "email" => "unique|fillable",
        "password" => "fillable",
    ];

    static protected array $defaultRelationalAttributes = [
        "folder" => "",
    ];

    public function getType(): string
    {
        return "user";
    }
}