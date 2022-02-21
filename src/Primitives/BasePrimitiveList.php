<?php

namespace Erupt\Primitives;

use Erupt\Foundation\BaseList;
use Erupt\Primitives\Items\{User, Post, Folder, Comment};
use Erupt\Plans\BasePlan;

abstract class BasePrimitiveList extends BaseList
{
    public static function make(string $str): BasePrimitive
    {
        return match($str) {
            "user" => new User,
            "post" => new Post,
            "folder" => new Folder,
            "comment" => new Comment,
        };
    }

    public function includes(BasePlan $plan): bool
    {
        foreach($this as $primitive) {
            if($primitive->is($plan)) {
                return true;
            }
        }

        return false;
    }

    public function getNames(): string
    {
        $names = [];

        foreach($this as $p) {
            $names[] = $p->getName();
        }

        return implode("&", $names);
    }

    public function add(BasePrimitive|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BasePrimitive|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}