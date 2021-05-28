<?php

namespace Erupt\Plans\Attributes\Lists;

use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Models\Properties\BaseProperty as ModelProp;
use Erupt\Models\Properties\Items\MorphOneToMany as CorrespondingModelProp;

class MorphOneToMany extends BaseAttributeList
{
    protected function makeCorrespondingModelProp($app, $model): ModelProp
    {
        return new CorrespondingModelProp($app, $model);
    }
}