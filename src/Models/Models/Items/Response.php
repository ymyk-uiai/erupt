<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Response extends BaseModel
{
    protected static $type = "response";

    public function get_model_type(): string
    {
        return "response";
    }
}