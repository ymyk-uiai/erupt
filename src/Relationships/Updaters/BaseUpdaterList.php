<?php

namespace Erupt\Relationships\Updaters;

use Erupt\Foundations\Lists\BaseList;

abstract class BaseUpdaterList extends BaseList
{
    protected static array $updaters = [
        "flag",
    ];

    public static function build($args): Self
    {
        $args = array_filter(explode(':', trim($args)));

        $list = new Static;

        $namespace = "Erupt\Relationships\Updaters\Items";

        foreach($args as $arg) {
            $exp = explode(',', $arg);
            
            $name = $exp[0];
            $ags = array_slice($exp, 1);

            $arg = trim($arg);

            if(in_array($arg, Self::$updaters)) {
                $class_name = "$namespace\\".ucfirst($name)."Updater";
            } else {
                $class_name = "$namespace\\FlagUpdater";
                array_unshift($ags, $name);
            }

            $updater = new $class_name($ags);

            $list->add($updater);
        }

        return $list;
    }

    //  Unit Type BaseUpdater|BaseUpdaterList
    public function add($updater)
    {
        parent::add($updater);
    }
}