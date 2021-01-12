<?php

namespace Erupt\Models\Models;

use Erupt\Abstracts\Models\Models\Model as AbstractModel;

class Content extends AbstractModel
{
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

    protected function get_model_type(): string
    {
        return "content";
    }
}