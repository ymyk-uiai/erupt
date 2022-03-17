<?php

namespace Erupt\Traits;

use Erupt\Models\Lists\ModelList;

trait HasModelList
{
    protected ModelList $models;

    public function getModelList(): ModelList
    {
        return $this->models;
    }
}