<?php

namespace Erupt\Relationships\Members;

use Erupt\Abstracts\Relationships\Members\Member as AbstractMember;
use Erupt\Relationships\Lists\Updaters\UpdaterList;
use Erupt\Relationships\Constructors\Members\MemberConstructor;

class Member extends AbstractMember
{
    protected ?string $name;

    protected ?string $type;

    protected ?UpdaterList $updaters;

    public function __construct()
    {
        //
    }

    public static function build($str)
    {
        $product = new Self;

        $pattern = "/^(?P<name>[a-zA-Z0-9]+)(?::(?P<args>[a-z]+(?:,[a-z]+)*))?/";

        preg_match($pattern, $str, $matches);

        $product->setName($matches["name"]);

        $product->setUpdaters(UpdaterList::build(array_key_exists("args", $matches) ? $matches["args"] : ""));

        return $product;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = trim($name);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = trim($type);
    }

    public function getUpdaters()
    {
        return $this->updaters;
    }

    public function setUpdaters(UpdaterList $updaters)
    {
        $this->updaters = $updaters;
    }
}