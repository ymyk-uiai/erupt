<?php

namespace Erupt\Traits;

use Erupt\Models\Values\Lists\ModelValueList;

trait HasModelValues
{
    protected ModelValueList $modelValues;

    public function setModelValueList(ModelValueList $modelValues): void
    {
        $this->modelValues = $modelValues;
    }

    public function getModelValueList(): ModelValueList
    {
        return $this->modelValues;
    }
}