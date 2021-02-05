<?php

namespace Erupt\Relationships\Members;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Relationships\Updaters\Lists\UpdaterList;

abstract class BaseMember extends BaseListItem
{
    protected string $name;

    protected ?string $type;

    protected UpdaterList $updaters;

    public static function build($str): Self
    {
        $product = new Static;

        $pattern = "/^(?P<name>[a-zA-Z0-9]+)(?::(?P<args>[a-z]+(?:,[a-z]+)*))?/";

        preg_match($pattern, $str, $matches);

        $product->set_name($matches["name"]);

        $product->set_updaters(UpdaterList::build(array_key_exists("args", $matches) ? $matches["args"] : ""));

        return $product;
    }

    public function set_name(string $name)
    {
        $this->name = trim($name);
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_type(string $type)
    {
        $this->type = trim($type);
    }

    public function get_type(): string
    {
        return $this->type;
    }

    public function set_updaters(UpdaterList $updaters)
    {
        $this->updaters = $updaters;
    }

    public function get_updaters(): UpdaterList
    {
        return $this->updaters;
    }
}