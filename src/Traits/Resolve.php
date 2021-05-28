<?php

namespace Erupt\Traits;

use Erupt\Interfaces\Resolver;

trait Resolve {

    public function resolve(string|array $keys): Resolver
    {
        $key = $this->getNextKey($keys);

        if($key == "") {
            return $this;
        }

        return $this->getResolver($key, $keys)->resolve($keys);
    }

    protected function getNextKey(string|array &$keys): string
    {
        if(is_string($keys)) {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        return $key ?? "";
    }

    abstract protected function getResolver(string $key, array &$keys): Resolver;
}