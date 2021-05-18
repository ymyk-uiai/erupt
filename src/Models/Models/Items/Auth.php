<?php

namespace Erupt\Models\Models\Items;

use Erupt\Models\Models\BaseModel;

class Auth extends BaseModel
{
    public static string $type = "auth";

    public static array $ordinaryFlags = [
        "id" => [
            "auth_id_1" => true,
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
        return "auth";
    }
}