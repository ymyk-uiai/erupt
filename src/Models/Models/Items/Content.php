<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Content extends BaseModel
{
    protected static $type = "content";

    public function get_model_type(): string
    {
        return "content";
    }
}