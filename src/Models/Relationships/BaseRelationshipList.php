<?php

namespace Erupt\Models\Relationships;

use Erupt\Foundations\Lists\BaseList;

abstract class BaseRelationshipList extends BaseList
{
    public static function build($model, $relationships): Self
    {
        $product = new Static;

        foreach($relationships as $relationship) {
            $relationship->get_model_relationships($model, $product);
        }

        return $product;
    }

    //  Unit Type BaseRelationship|BaseRelationshipList
    public function add($relationship)
    {
        parent::add($relationship);
    }

    public function remove($relationship)
    {
        parent::remove($relationship);
    }

    public function resolve($keys, $app)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $relationships = new Static;

        foreach($this->list as $relationship) {
            if($relationship->get_flag($key)) {
                $relationships->add($relationship);
            }
        }

        return $relationships->resolve($keys, $app);
    }

    public function resolve1($keys, $app)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        if(empty($keys)) {
            return $this;
        }

        $key = array_shift($keys);

        $relationships = new Static;

        foreach($this->list as $relationship) {
            if($relationship->get_flag($key)) {
                return $relationship;
            }
        }
    }
}