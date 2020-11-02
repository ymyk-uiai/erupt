<?php

namespace Erupt\Relationships\Constructors\Lists\Updaters;

use Erupt\Relationships\Lists\Updaters\UpdaterList;

class UpdaterListConstructor
{
    public UpdaterList $list;

    public function __construct($args)
    {
        $args = array_filter(explode(':', trim($args)));

        $list = new UpdaterList;

        $namespace = "Erupt\Relationships\Updaters";

        foreach($args as $arg) {
            $exp = explode(',', $arg);
            
            $name = $exp[0];
            $ags = array_slice($exp, 1);

            $arg = trim($arg);

            $className = "$namespace\\".ucfirst($name)."Updater";

            $updater = new $className($ags);

            $list->add($updater);
        }

        $this->list = $list;
    }
}