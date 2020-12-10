<?php

namespace Erupt\Models\Models;

use Erupt\Abstracts\Models\Models\Model as AbstractModel;

class Response extends AbstractModel
{
    protected $type = "response";

    public function getCommandSeedKeys()
    {
        return [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
            "factory",
            "seeder",
            "migration",
        ];
    }
}