<?php

namespace Erupt\Relationships\Constructors\Members;

use Erupt\Relationships\Lists\Updaters\UpdaterList;

class MemberConstructor
{
    public $name;

    public $type;

    public $updaters;
    
    public function __construct($name, $type, $args)
    {
        //  $name, $type, $args
        $this->name = trim($name);

        $type = trim($type);

        $this->type = $type;

        if($type == "auth") {
            $args .= "flag,required";
        }

        $this->updaters = UpdaterList::build($args);
    }
}