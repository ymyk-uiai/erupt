<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Binder extends BaseModel
{
    protected static $type = "binder";

    public static array $ordinaryFlags = [
        "id" => [
            "binder_id_1" => true,
            "test2" => false,
        ],
    ];

    public static array $relationshipFlags = [
        "binder" => [
            "binder_relationship" => true,
        ],
    ];

    public function get_model_type(): string
    {
        return "binder";
    }
}