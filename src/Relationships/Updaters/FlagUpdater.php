<?php

namespace Erupt\Relationships\Updaters;

use Erupt\Abstracts\Relationships\Updaters\Updater;
use Erupt\Models\Relationships\Relationship;

class FlagUpdater extends Updater
{
    protected $args = [];

    public function __construct($args)
    {
        $this->args = array_merge($this->args, $args);
    }

    public function update(Relationship $relationship)
    {
        foreach($this->args as $arg) {
            $relationship->setFlag($arg, true);
        }
    }
}