<?php

namespace Erupt\Traits;

use Erupt\Models\ModelValues\BaseModelValueList as ModelValueList;
use Erupt\Models\ModelValues\BaseModelValue as ModelValue;

trait HasModelValueList
{
    protected ModelValueList $values;

    public function setModelValues(ModelValueList $modelValues): void
    {
        $this->values = $modelValues;
    }

    public function getModelValues(): ModelValueList
    {
        return $this->values;
    }

    public function updateModelValues(ModelValue $value): void
    {
        $this->values->add($value);
    }
}