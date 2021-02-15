<?php

namespace Erupt\Specifications\Specifications\Lists;

use Erupt\Specifications\Specifications\BaseSpecificationList;
use Erupt\Specifications\Specifications\BaseSpecification;
use Erupt\Specifications\Makers\Lists\MakerList;
use Erupt\Application;
use Erupt\Specifications\Makers\Lists\FileMakerList;

class FileSpecificationList extends BaseSpecificationList
{
    public static function build(MakerList $makers, Application $app): Self
    {
        $file_makers = FileMakerList::filter($makers);

        $specs = new Self;

        foreach($file_makers as $file_maker) {
            $specs->add($app->get_generators()->make_file_specs($file_maker));
        }

        return $specs;
    }

    public function resolve($model, $keys)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = array_shift($keys);

        return $this->get_spec($model, $key)->resolve($keys);
    }

    public function get_spec($model, $keys): BaseSpecification
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        $key = trim(array_shift($keys));

        foreach($this->list as $item) {
            if($item->get_model_name() == $model->get_name()) {
                if($item->get_model_type() == $model->get_model_type()) {
                    if($item->get_template_key() == $key) {
                        return $item;
                    }
                }
            }
        }

        throw new \Error("file spec not found. \$key = {$key}");
    }
}