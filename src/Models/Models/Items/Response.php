<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Response extends BaseModel
{
    protected static $type = "response";

    public static array $ordinaryFlags = [
        "id" => [
            "response_id_1" => true,
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
        return "response";
    }
}