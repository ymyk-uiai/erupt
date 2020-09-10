<?php

namespace Erupt\Plans\Attributes;

use Erupt\Abstracts\Plans\Attributes\Attribute as AbstractAttribute;
use Erupt\Plans\Constructors\Attributes\TimestampsAttributeConstructor;
use Erupt\Plans\Containers\Updaters\UpdaterContainer;
use Erupt\Plans\Lists\Updaters\UpdaterList;
use Erupt\Plans\Constructors\Attributes\TimestampAttribute;
use Erupt\Plans\Constructors\Attributes\NullableAttribute;

class TimestampsAttribute extends AbstractAttribute
{
    protected $precision;

    public function __construct()
    {
        //
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    public static function build($args): Self
    {
        return TimestampsAttributeConstructor::build($args);
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