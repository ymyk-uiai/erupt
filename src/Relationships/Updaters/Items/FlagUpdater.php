<?php

namespace Erupt\Relationships\Updaters\Items;

use Erupt\Relationships\Updaters\BaseUpdater;
use Erupt\Models\Relationships\BaseRelationship as Relationship;

class FlagUpdater extends BaseUpdater
{
    protected $args = [];

    public function __construct($args)
    {
        $this->args = array_merge($this->args, $args);
    }

    public function update(Relationship $relationship)
    {
        foreach($this->args as $arg) {
            $relationship->set_flag($arg, true);
        }
    }
}