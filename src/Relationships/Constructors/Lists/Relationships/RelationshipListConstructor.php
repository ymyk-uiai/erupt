<?php

namespace Erupt\Relationships\Constructors\Lists\Relationships;

use Erupt\Relationships\Lists\Relationships\RelationshipList;
use Erupt\Relationships\Members\Member;
use Erupt\Relationships\Relationships\Relationship;
use Erupt\Relationships\Relationships\UnformOneToOne;
use Erupt\Relationships\Relationships\UniformOneToMany;
use Erupt\Relationships\Relationships\UniformManyToMany;
use Erupt\Abstracts\Relationships\Relationships\UniformRelationship;
use Erupt\Abstracts\Relationships\Relationships\PolymorphicRelationship;

class RelationshipListConstructor
{
    protected static $oneToOne = [];

    protected static $oneToMany = [
        "auth" => [
            "content",
            "response",
            "binder",
        ],
        "content" => [
            "response",
        ],
        "response" => [
            "response",
        ],
        "binder" => [
            "content",
            "response",
        ],
    ];

    protected static $manyToMany = [];

    protected static $polymorphic = [
        [
            "content" => "response",
            "response" => "response",
            "binder" => "response",
        ],
    ];

    public static function build($config)
    {
        $data = $config["relationships"];

        $list = new RelationshipList;

        foreach($data as $sb => $ob) {
            $obs = explode('#', $ob);

            $sbMember = Member::build($sb, Self::getType($config, $sb), "");

            //$sbMember = new Member(new MemberConstructor($sb, $this->getType($config, $sb), ""));

            foreach($obs as $o) {
                $exp = explode('@', $o);
                $name = $exp[0];
                $type = Self::getType($config, $name);
                $args = array_key_exists(1, $exp) ? $exp[1] : "";

                //$obMember = new Member($o, $this->getType($config, $o));
                //$obMember = new Member(new MemberConstructor($name, $type, $args));
                $obMember = Member::build($name, $type, $args);

                //$relationship = $this->makeRelationship($sbMember, $obMember);

                $relationship = Self::makeRelationship($sbMember, $obMember);

                $list->add($relationship);
            }
        }

        foreach($list as $relationship) {
            if($relationship instanceof UniformRelationship) {
                if($poly = $relationship->tryMorph()) {
                    $list->remove($relationship);

                    Self::mergePoly($list, $poly);
                }
            }
        }

        foreach($list as $relationship) {
            if($relationship instanceof PolymorphicRelationship) {
                if($uni = $relationship->tryUni()) {
                    $list->remove($relationship);

                    $list->add($uni);
                }
            }
        }

        return $list;
    }

    protected static function getType($config, $model)
    {
        return $config["models"][$model]["type"];
    }

    protected static function makeRelationship(Member $sb, Member $ob)
    {
        $polyIndex = Self::findPolyIndex($sb, $ob);

        if(Self::is(Self::$oneToOne, $sb, $ob)) {

            return UnformOneToOne::build($sb, $ob, $polyIndex);

        } else if(Self::is(Self::$oneToMany, $sb, $ob)) {

            return UniformOneToMany::build($sb, $ob, $polyIndex);

        } else if(Self::is(Self::$manyToMany, $sb, $ob)) {
            
            return UniformManyToMany::build($sb, $ob, $polyIndex);

        }

        print_r("no type\n");
        print_r($sb);
        print_r($ob);
    }

    protected static function is($kind, Member $sb, Member $ob)
    {
        return array_key_exists($sb->getType(), $kind)
            && in_array($ob->getType(), $kind[$sb->getType()]);
    }

    protected static function findPolyIndex(Member $sb, Member $ob)
    {
        foreach(Self::$polymorphic as $index => $group) {
            foreach($group as $sbj => $obj) {
                if($sb->getType() === $sbj && $ob->getType() === $obj) {
                    return $index;
                }
            }
        }

        return -1;
    }

    protected static function mergePoly($list, PolymorphicRelationship $relationship)
    {
        foreach($list as $r) {
            if($r instanceof PolymorphicRelationship) {
                if($r->tryMerge($relationship)) {
                    return;
                }
            }
        }

        $list->add($relationship);
    }
}