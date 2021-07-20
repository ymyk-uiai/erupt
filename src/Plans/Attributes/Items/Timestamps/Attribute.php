<?php

namespace Erupt\Plans\Attributes\Items\Timestamps;

use Erupt\Plans\Attributes\BaseAttribute;
use Erupt\Interfaces\SchemaCommand;
use Erupt\Plans\Attributes\Containers\AttributeContainer;
use Erupt\Plans\Attributes\Lists\AttributeList;
use Erupt\Plans\Attributes\Items\Timestamp\Attribute as TimestampAttribute;
use Erupt\Plans\Attributes\Items\Nullable\Attribute as NullableAttribute;

class Attribute extends BaseAttribute implements SchemaCommand
{
    protected string $params = "precision?";

    public function getPropertyName(): string
    {
        return "timestamps";
    }
    protected string $migrationMethodName = "timestamps";

    public function evaluate()
    {
        $container = new AttributeContainer;

        $list_1 = new AttributeList;
        $list_2 = new AttributeList;

        $container->add($list_1);
        $container->add($list_2);

        $m_1_1 = new TimestampAttribute(["name" => "created_at", "precision" => $this->args['precision']], $this->root);
        $m_1_2 = new NullableAttribute("", $this->root);

        $m_2_1 = new TimestampAttribute(["name" => "updated_at", "precision" => $this->args['precision']], $this->root);
        $m_2_2 = new NullableAttribute("", $this->root);

        $list_1->add($m_1_1->evaluate());
        $list_1->add($m_1_2->evaluate());

        $list_2->add($m_2_1->evaluate());
        $list_2->add($m_2_2->evaluate());
        
        return $container;
    }
}