<?php

namespace Erupt\Relationships\Lists\Updaters;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Relationships\Constructors\Lists\Updaters\UpdaterListConstructor;

class UpdaterList extends BaseList
{
    public function __construct()
    {
        //
    }

    public static function build($args)
    {
        $result = new Self;

        $constructor = new UpdaterListConstructor($args);

        $result->add($constructor->list);

        return $result;

        //  return $constructor->result;
    }

    public function add($updater)
    {
        parent::add($updater);
    }
}