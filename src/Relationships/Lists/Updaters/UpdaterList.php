<?php

namespace Erupt\Relationships\Lists\Updaters;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Relationships\Constructors\Lists\Updaters\UpdaterListConstructor;

class UpdaterList extends BaseList
{
    protected static array $updaters = [
        "flag",
    ];

    public static function build($args)
    {
        $args = array_filter(explode(':', trim($args)));

        $list = new UpdaterList;

        $namespace = "Erupt\Relationships\Updaters";

        foreach($args as $arg) {
            $exp = explode(',', $arg);
            
            $name = $exp[0];
            $ags = array_slice($exp, 1);

            $arg = trim($arg);

            if(in_array($arg, Self::$updaters)) {
                $className = "$namespace\\".ucfirst($name)."Updater";
            } else {
                $className = "$namespace\\FlagUpdater";
                array_unshift($ags, $name);
            }

            $updater = new $className($ags);

            $list->add($updater);
        }

        return $list;
    }

    public function add($updater)
    {
        parent::add($updater);
    }
}