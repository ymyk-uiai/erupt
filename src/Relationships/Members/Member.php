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

    public static function build($name, $type, $args)
    {
        $result = new Self;

        $constructor = new MemberConstructor($name, $type, $args);

        $result->setName($constructor->name);

        $result->setType($constructor->type);

        $result->setUpdaters($constructor->updaters);

        return $result;

        //  return MemberConstructor::build($name, $type, $args);
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