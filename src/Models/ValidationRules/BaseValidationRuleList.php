<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Interfaces\Resolver;
use Erupt\Foundations\ResolverList;
use Erupt\Tratis\HasList;

abstract class BaseValidationRuleList extends ResolverList
{
    public function add() {}

    public function remove() {}

    protected function getResolver(string $key, array &$keys): Resolver
    {
        $props = Static::empty();

        foreach($this->list as $prop) {
            if($prop->get_flag($key)) {
                $props->add($prop);
            }
        }

        return $props;
    }

    public function evaluate()
    {
        return $this;
    }
}