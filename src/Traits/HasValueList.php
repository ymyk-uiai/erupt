<?php

namespace Erupt\Traits;

use Erupt\Values\Lists\ValueList;

trait HasValueList
{
    protected ValueList $values;

    public function getValueList(): ValueList
    {
        return $this->values;
    }

    public static function buildList(): self
    {
        $this->values = ValueList::build();
    }

    public function initValueList(): void
    {
        if(!isset($this->values)) {
            $this->values = ValueList::init();
        }
    }

    //  public static function buildValueList(): void
}