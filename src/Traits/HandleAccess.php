<?php

namespace Erupt\Traits;

use Erupt\Interfaces\Accessor;

trait HandleAccess
{
    public function access(string $keys, int $index = 0): Accessor
    {
        //  https://stackoverflow.com/a/62437421
        $variables = get_object_vars($this);
        $key = $this->getNextKey($keys, $index);

        if(empty($key)) {
            return $this;
        }

        foreach($variables as $variable) {
            if($variable instanceof Accessor) {
                $accessKeys = get_class($variable)::getAccessKeys();
                if(in_array($key, $accessKeys)) {
                    return $variable->access($keys, $index+1);
                }
            }
        }
        
        return $this->accessAdditionally($keys, $index);
    }

    protected function getNextKey(string $keys, int $index): ?string
    {
        $keys = explode('.', $keys);

        if($index >= count($keys)) {
            return null;
        }

        return $keys[$index];
    }

    public static function getAccessKeys(): array
    {
        return static::$accessKeys;
    }

    protected function accessAdditionally(string $keys, int $index): Accessor
    {
        throw new \Exception($keys);
    }
}