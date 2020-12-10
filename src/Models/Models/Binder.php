<?php

namespace Erupt\Models\Models;

use Erupt\Abstracts\Models\Models\Model as AbstractModel;

class Binder extends AbstractModel
{
    protected $type = "binder";

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
            "component/card"
        ];
    }
}