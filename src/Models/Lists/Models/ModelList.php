<?php

namespace Erupt\Models\Lists\Models;

use Erupt\Abstracts\Foundations\BaseList;

class ModelList extends BaseList
{
    public function add($model)
    {
        parent::add($model);
    }

    public function remove($model)
    {
        parent::remove($model);
    }

    public function get($name)
    {
        foreach($this->list as $model) {
            if($model->getName() == $name) {
                return $model;
            }
        }

        return false;
    }

    public function getByType($type)
    {
        foreach($this->list as $model) {
            if($model->getType() == $type) {
                return $model;
            }
        }

        return false;
    }
}