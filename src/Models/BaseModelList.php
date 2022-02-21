<?php

namespace Erupt\Models;

use Erupt\Foundation\BaseList;
use Erupt\Plans\Lists\PlanList;
use Exception;

abstract class BaseModelList extends BaseList
{
    public static function build(PlanList $plans): static
    {
        $product = new static;

        foreach($plans as $plan) {
            $product->add($plan->makeModel());
        }

        return $product;
    }

    public function get(string $name): BaseModel
    {
        try {
            foreach($this as $model) {
                if($model->getName() == trim($name)) {
                    return $model;
                }
            }
            throw new Exception($name);
        } catch (Exception $e) {
            echo 'Unknown model type: ', $e->getMessage(), "\n";
        }
    }

    public function add(BaseModel|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseModel|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}