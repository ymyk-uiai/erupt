<?php

namespace Erupt\Traits;

use Erupt\Models\Models\BaseModel as Model;

trait BelongsToModel
{
    protected Model $model;

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}