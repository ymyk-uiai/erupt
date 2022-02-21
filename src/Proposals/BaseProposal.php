<?php

namespace Erupt\Proposals;

use Erupt\Foundation\BaseListItem;
use Erupt\Attributes\BaseAttribute as Attribute;
use Erupt\Attributes\Lists\AttributeList;
use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Properties\BasePropertyList;

abstract class BaseProposal extends BaseListItem
{
    protected AttributeList $attrs;

    public function __construct()
    {
        $this->attrs = new AttributeList;
    }

    public static function build(string $prop): static
    {
        $product = new static;
        $attrs = explode("|", $prop);

        foreach ($attrs as $attr) {
            $product->attrs->add(Attribute::build($attr));
        }
        return $product;
    }

    public function getAttrs(): AttributeList
    {
        return $this->attrs;
    }

    abstract public function makeCorrespondingAttributeContainer(): BaseAttributeContainer;

    public function makeProperties(): BasePropertyList
    {
        $container = $this->makeCorrespondingAttributeContainer();
        foreach($this->attrs as $attr) {
            $container->merge($attr->evaluate());
        }
        return $container->makeProperties();
    }
}