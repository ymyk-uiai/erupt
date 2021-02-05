<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Auth extends BaseModel
{
    public static string $type = "auth";

    public function get_model_type(): string
    {
        return "auth";
    }
}