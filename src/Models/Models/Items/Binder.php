<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Binder extends BaseModel
{
    protected static $type = "binder";

    public function get_model_type(): string
    {
        return "binder";
    }
}