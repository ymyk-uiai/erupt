<?php

namespace Erupt\Models\Models;

use Erupt\Abstracts\Models\Models\Model as AbstractModel;

class Auth extends AbstractModel
{
    protected $type = "auth";

    public function getCommandSeedKeys()
    {
        return [
            "model",
            "policy",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
            "migration",
            "component/card"
        ];
    }
}