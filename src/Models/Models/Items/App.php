<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class App extends BaseModel
{
    public static string $type = "auth";

    protected string $name = "app";

    public function get_model_type(): string
    {
        return "app";
    }
}