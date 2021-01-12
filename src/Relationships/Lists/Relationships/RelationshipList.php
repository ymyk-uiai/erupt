<?php

namespace Erupt\Relationships\Lists\Relationships;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Relationships\Constructors\Lists\Relationships\RelationshipListConstructor;
use Erupt\Relationships\Relationships\MonoOneToMany;
use Erupt\Relationships\Relationships\PolyOneToMany;

class RelationshipList extends BaseList
{
    public function __construct()
    {
        //
    }

    /*
    public static function build($config)
    {
        return RelationshipListConstructor::build($config);
    }
    */

    public static function build($config, $app)
    {
        $relationship_plans = $config["relationships"];

        $list = new Self;

        foreach($relationship_plans as $plan) {
            $delimiter = Self::getDelimiter($plan);

            [$lhs, $rhs] = explode($delimiter, $plan);

            if($delimiter == "->") {
                // one to one
            } else if($delimiter == "=>") {
                $relationships = Self::OneToMany($lhs, $rhs);
            } else if($delimiter == "<=>") {
                // many to many
            } else if($delimiter == "~>") {
                // polymorphic one to many
                $relationships = Self::PolymorphicOneToMany($lhs, $rhs, $app);
            } else {
                throw new Exception("Unknown delimiter");
            }

            $list->add($relationships);
        }

        return $list;
    }

    protected static function getDelimiter($str)
    {
        $pattern = "/->|=>|<=>|~>/";

        preg_match($pattern, $str, $matches);

        return $matches[0];
    }

    protected static function OneToOne($lhs, $rhs)
    {
        //
    }

    protected static function OneToMany($lhs, $rhs)
    {
        $l = $lhs;
        $rs = explode('#', $rhs);

        $list = new Self;

        foreach($rs as $r) {
            $list->add(MonoOneToMany::build($l, $r));
        }

        return $list;
    }

    protected static function ManyToMany($lhs, $rhs)
    {
        //
    }

    protected static function PolymorphicOneToOne($lhs, $rhs)
    {
        //
    }

    protected static function PolymorphicOneToMany($lhs, $rhs, $app)
    {
        $ls = explode('#', $lhs);
        $r = $rhs;

        $list = new Self;

        $list->add(PolyOneToMany::build($ls, $r, $app));

        return $list;
    }

    protected static function PolymorphicManyToMany($lhs, $rhs)
    {
        //
    }

    public function add($relationship)
    {
        parent::add($relationship);
    }

    public function remove($relationship_s)
    {
        parent::remove($relationship_s);
    }
}