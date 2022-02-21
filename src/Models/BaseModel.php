<?php

namespace Erupt\Models;

use Erupt\Foundation\BaseListItem;
use Erupt\Properties\Lists\PropertyList;

abstract class BaseModel extends BaseListItem
{
    protected PropertyList $properties;

    public function __construct()
    {
        $this->properties = new PropertyList;
    }

    public function getProperties(): PropertyList
    {
        return $this->properties;
    }

    abstract public function getName(): string;

    public function resolve(string|array $keys)
    {
        $key = $this->getNextKey($keys);

        if($key == "") {
            return $this;
        }

        return $this->getResolver($key, $keys)->resolve($keys);
    }

    protected function getResolver(string $key, array &$keys)
    {
        try {
            if($key == "name") {
                array_push($keys, "model");
                array_push($keys, "name");
            }
            return match($key) {
                "name" => $this->getFiles(),
                "values" => $this->getValues(),
                "attributes",
                "props" => $this->getProperties(),
                "files" => $this->getFiles(),
                "className" => $this->getValues()->getValue('className'),
                default => throw new Exception($key),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ',  $e->getMessage(), "\n";
        }
    }

    protected function getNextKey(string|array &$keys): string
    {
        if(is_string($keys)) {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        return $key ?? "";
    }
}