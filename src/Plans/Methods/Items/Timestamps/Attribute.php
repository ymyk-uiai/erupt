<?php

namespace Erupt\Plans\Methods\Items\Timestamps;

use Erupt\Plans\Methods\BaseAttribute;
use Erupt\Plans\Methods\Lists\UpdaterList;
use Erupt\Plans\Methods\Containers\UpdaterContainer;
use Erupt\Plans\Methods\Items\Timestamp\Attribute as TimestampAttribute;
use Erupt\Plans\Methods\Items\Nullable\Attribute as NullableAttribute;

class Attribute extends BaseAttribute
{
    protected $precision;

    public static function build($args): Self
    {
        $product = new Self;

        $params = Self::parse_params("precision?", $args);

        $product->set_precision($params["precision"]);

        return $product;
    }

    public function set_precision($precision)
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