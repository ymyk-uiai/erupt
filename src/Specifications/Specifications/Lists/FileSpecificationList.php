<?php

namespace Erupt\Specifications\Specifications\Lists;

use Erupt\Specifications\Specifications\BaseSpecificationList;
use Erupt\Specifications\Specifications\BaseSpecification;
use Erupt\Specifications\Makers\Lists\MakerList;
use Erupt\Models\Models\Items\App;
use Erupt\Application;
use Erupt\Specifications\Makers\Lists\FileMakerList;
use Erupt\Models\Properties\Lists\PropertyList; 
use Erupt\Models\Models\BaseModel as Model;

class FileSpecificationList extends BaseSpecificationList
{
    public static function build(MakerList $makers, Application $app): Self
    {
        $file_makers = FileMakerList::filter($makers);

        $specs = new Self;

        foreach($file_makers as $file_maker) {
            $specs->add($app->getGenerators()->make_file_specs($file_maker));
        }

        return $specs;
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

    public function filter(Model $model): Self
    {
        $product = Self::empty();

        foreach($this as $file) {
            if($model->getType() == $file->get_model_type()) {
                $product->add($file);
            }
        }

        return $product;
    }
}