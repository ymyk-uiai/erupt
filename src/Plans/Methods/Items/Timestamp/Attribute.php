<?php

namespace Erupt\Plans\Methods\Items\Timestamp;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Items\Timestamp\Updater as TimestampUpdater;
use Erupt\Interfaces\SchemaMethod;

class Attribute extends BaseAttribute implements SchemaMethod
{
    protected $name;

    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("name, precision?", $args);

        $product->set_name($params["name"]);

        $product->set_precision($params["precision"]);

        return $product;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_precision($precision)
    {
        $this->precision = $precision;
    }

    public function run()
    {
        $updaterList = new UpdaterList;

        $updater = TimestampUpdater::build(["name" => $this->name, "precision" => $this->precision]);

        $updaterList->add($updater);

        return $updaterList;
    }

    public function get_schema_method(): string
    {
        return $this->name == "email_verified_at" ? "timestamp('email_verified_at')->nullable()" : "timestamp('{$this->name}')";
    }
}