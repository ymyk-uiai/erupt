<?php

namespace Erupt\Models\Models;

use Erupt\Abstracts\Models\Models\Model as AbstractModel;

class Content extends AbstractModel
{
    protected $type = "content";

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