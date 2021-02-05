<?php

namespace Erupt\Specifications\Makers\Lists;

use Erupt\Specifications\Makers\BaseMakerList;
use Erupt\Interfaces\Makers\BaseMaker;

class MakerList extends BaseMakerList
{
    public static function build($models, $relationships): Self
    {
        $makers = new Self;

        foreach($models as $model) {
            if($model instanceof BaseMaker) {
                $makers->add($model);
            }
        }

        foreach($relationships as $relationship) {
            if($relationships instanceof BaseMaker) {
                $makers->add($relationship);
            }
        }

        return $makers;
    }
}