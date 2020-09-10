<?php

namespace Erupt\Relationships\Constructors\Lists\Updaters;

use Erupt\Relationships\Lists\Updaters\UpdaterList;

class UpdaterListConstructor
{
    public UpdaterList $list;

    public function __construct($args)
    {
        $args = array_filter(explode(',', trim($args)));

        $list = new UpdaterList;

        $namespace = "Erupt\Relationships\Updaters";

        foreach($args as $arg) {
            $arg = trim($arg);

            $className = "$namespace\\".ucfirst($arg)."Updater";

            $updater = new $className;

            $list->add($updater);
        }

        $this->list = $list;
    }
}