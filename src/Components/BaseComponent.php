<?php

namespace Erupt\Components;

use Erupt\Foundation\BaseListItem;
use Erupt\Files\BaseFile;

abstract class BaseComponent extends BaseListItem
{
    protected string $template;

    public static function compile(): static
    {
        $component = new static;

        foreach($component->components as $key => $value) {
            $component->merge($key, $value::compile());
        }

        unset($component->components);

        return $component;
    }

    protected function merge(string $name, self $component): void
    {
        $vars = get_object_vars($component);

        foreach($vars as $key => $value) {
            if(is_array($value)) {
                $this->{$key} = array_merge($this->{$key}, $value);
            }
        }

        $this->template = str_replace($name, $component->template, $this->template);
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}