<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Relationships\Relationships\Items\MonoOneToMany;
use Erupt\Relationships\Relationships\Items\PolyOneToMany;

class BaseRelationshipList extends BaseList
{
    public static function build($config, $app): Static
    {
        $relationship_plans = $config["relationships"];

        $list = new Static;

        foreach($relationship_plans as $index => $plan) {
            $delimiter = Self::get_delimiter($plan);

            [$lhs, $rhs] = explode($delimiter, $plan);

            if($delimiter == "->") {
                // one to one
            } else if($delimiter == "=>") {
                $relationships = Self::mono_one_to_many($index, $lhs, $rhs);
            } else if($delimiter == "<=>") {
                // many to many
            } else if($delimiter == "~>") {
                // polymorphic one to many
                $relationships = Self::poly_one_to_many($index, $lhs, $rhs, $app);
            } else {
                throw new Exception("Unknown delimiter");
            }

            $list->add($relationships);
        }

        return $list;
    }

    protected static function get_delimiter($str)
    {
        $pattern = "/->|=>|<=>|~>/";

        preg_match($pattern, $str, $matches);

        return $matches[0];
    }

    protected static function mono_one_to_one($lhs, $rhs)
    {
        //
    }

    protected static function mono_one_to_many($index, $lhs, $rhs)
    {
        $l = $lhs;
        $rs = explode('#', $rhs);

        $list = new Self;

        foreach($rs as $r) {
            $list->add(MonoOneToMany::build($index, $l, $r));
        }

        return $list;
    }

    protected static function mono_many_to_many($lhs, $rhs)
    {
        //
    }

    protected static function poly_one_to_one($lhs, $rhs)
    {
        //
    }

    protected static function poly_one_to_many($index, $lhs, $rhs, $app)
    {
        $ls = explode('#', $lhs);
        $r = $rhs;

        $list = new Self;

        $list->add(PolyOneToMany::build($index, $ls, $r, $app));

        return $list;
    }

    protected static function poly_many_to_many($lhs, $rhs)
    {
        //
    }

    //  Unit Type BaseRelationship|BaseRelationship|List
    public function add($relationship)
    {
        parent::add($relationship);
    }

    public function remove($relationship_s)
    {
        parent::remove($relationship_s);
    }
}