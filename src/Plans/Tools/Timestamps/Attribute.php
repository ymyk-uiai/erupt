<?php

namespace Erupt\Plans\Tools\Timestamps;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Containers\Updaters\UpdaterContainer;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Tools\Timestamp\Attribute as TimestampAttribute;
use Erupt\Plans\Tools\Nullable\Attribute as NullableAttribute;

class Attribute extends AbstractAttribute
{
    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parseParams("precision?", $args);

        $product->setPrecision($params["precision"]);

        return $product;
    }

    public function __construct()
    {
        //
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    public function run()
    {
        $container = new UpdaterContainer;

        $list_1 = new UpdaterList;
        $list_2 = new UpdaterList;

        $container->add($list_1);
        $container->add($list_2);

        $m_1_1 = TimestampAttribute::build(["name" => "created_at", "precision" => $this->precision]);
        $m_1_2 = NullableAttribute::build();

        $m_2_1 = TimestampAttribute::build(["name" => "updated_at", "precision" => $this->precision]);
        $m_2_2 = NullableAttribute::build();

        $list_1->add($m_1_1->run());
        $list_1->add($m_1_2->run());

        $list_2->add($m_2_1->run());
        $list_2->add($m_2_2->run());
        
        return $container;
    }
}