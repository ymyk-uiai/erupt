<?php

namespace Erupt\Models\ValidationRules;

use Erupt\Foundations\Resolver;
use Erupt\Tratis\HasList;

abstract class BaseValidationRuleList extends Resolver
{
    use HasList;

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
}