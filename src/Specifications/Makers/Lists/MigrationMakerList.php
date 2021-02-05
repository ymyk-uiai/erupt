<?php

namespace Erupt\Specifications\Makers\Lists;

use Erupt\Specifications\Makers\BaseMakerList;
use Erupt\Interfaces\Makers\Items\MigrationMaker;

class MigrationMakerList extends BaseMakerList
{
    public static function build(BaseMakerList $makers): Self
    {
        $file_makers = self::filter($makers);

        return $file_makers;
    }

    public static function filter(BaseMakerList $makers): Self
    {
        $list = new Self;

        foreach($makers as $maker) {
            if($maker instanceof MigrationMaker) {
                $list->add($maker);
            }
        }

        return $list;
    }

    //  Unit Type
    public function add($maker)
    {
        parent::add($maker);
    }
}