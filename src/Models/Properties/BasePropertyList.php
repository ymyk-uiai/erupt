<?php

namespace Erupt\Models\Properties;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Plnas\Properties\Lists\PlanPropertyList;
use Erupt\Models\Properties\Items\Property as ModelProperty;
use Erupt\Models\Properties\Lists\PropertyList as ModelProperties;
use Erupt\Plans\Properties\Lists\PropertyList as PlanProperties;
use Erupt\Plans\Methods\Containers\UpdaterContainer;
use Erupt\Models\Properties\Items\Property;

abstract class BasePropertyList extends BaseList
{
    public static function build(PlanProperties $planProperties, $app): ModelProperties
    {
        $propertyList = new ModelProperties;

        $rootContainer = new UpdaterContainer;

        foreach($planProperties as $planProperty) {

            $container = new UpdaterContainer;

            foreach($planProperty->get_attributes() as $attribute) {

                $sbj = $attribute->run();

                if($container->count() === 0) {
                    $container->add($sbj);
                } else {
                    foreach($container as $list) {
                        $list->add($sbj);
                    }
                }
            }

            $rootContainer->add($container);
        }

        foreach($rootContainer as $list) {
            $modelProperty = ModelProperty::build($app);

            foreach($list as $item) {
                $item->run($modelProperty);
            }

            $propertyList->add($modelProperty);
        }

        return $propertyList;
    }

    //  Unit Type BaseProperty|BasePropertyList
    public function add($property)
    {
        parent::add($property);
    }

    public function remove($property)
    {
        parent::remove($property);
    }
}