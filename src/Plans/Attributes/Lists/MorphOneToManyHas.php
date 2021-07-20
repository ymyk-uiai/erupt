<?php

namespace Erupt\Plans\Attributes\Lists;

use Erupt\Plans\Attributes\BaseAttributeList;
use Erupt\Models\Properties\BaseProperty as ModelProp;
use Erupt\Models\Properties\Items\MorphOneToManyHas as CorrespondingModelProp;

class MorphOneToManyHas extends BaseAttributeList
{
    protected function makeCorrespondingModelProp($app, $model): ModelProp
    {
        return new CorrespondingModelProp($app, $model);
    }
}