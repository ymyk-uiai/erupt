<?php

namespace Erupt\Specifications\Specifications;

use Erupt\Foundations\ResolverList;
use Erupt\Specifications\Specifications\BaseSpecification;
use Erupt\Interfaces\Resolver;
use Exception;

class BaseSpecificationList extends ResolverList
{
    public function get(string $key)
    {
        foreach($this as $file) {
            if($key == $file->get_template_key()) {
                return $file;
            }
        }

        throw new Exception($key);
    }
    protected function getResolver(string $key, array &$keys): Resolver
    {
        return $this->get($key);
    }

    public function evaluate()
    {
        return $this;
    }

    public function add($specification)
    {
        parent::addItemOrList($specification);
    }
}