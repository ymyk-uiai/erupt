<?php

namespace Erupt\Specifications\Makers\Lists;

use Erupt\Specifications\Makers\BaseMakerList;
use Erupt\Interfaces\Maker;

class MakerList extends BaseMakerList
{
    public static function build($models, $relationships): Self
    {
        $makers = new Self;

        foreach($models as $model) {
            if($model instanceof Maker) {
                $makers->add($model);
            }
        }

        foreach($relationships as $relationship) {
            if($relationships instanceof Maker) {
                $makers->add($relationship);
            }
        }

        return $makers;
    }
}