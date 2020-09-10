<?php

namespace Erupt\Plans\Lists\Plans;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Plans\Constructors\Lists\Plans\PlanListConstructor;

class PlanList extends BaseList
{
    public function __construct()
    {
        //
    }

    public static function build($config, $relationships): Self
    {
        return  PlanListConstructor::build($config, $relationships);
    }

    public function add($plan)
    {
        parent::add($plan);
    }
}