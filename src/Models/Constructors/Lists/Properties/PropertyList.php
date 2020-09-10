<?php

namespace Erupt\Models\Constructors\Lists\Properties;

use Erupt\Models\Lists\Properties\PropertyList as ModelPropertyList;
use Erupt\Plans\Lists\Properties\PropertyList as PlanPropertyList;
use Erupt\Plans\Containers\Updaters\UpdaterContainer;
use Erupt\Models\Properties\Property as ModelProperty;

class PropertyList
{
    public static function build(PlanPropertyList $planProperties): ModelPropertyList
    {
        $propertyList = new ModelPropertyList;

        $rootContainer = new UpdaterContainer;

        foreach($planProperties as $planProperty) {

            $container = new UpdaterContainer;

            foreach($planProperty->getAttributes() as $attribute) {

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
            $modelProperty = new ModelProperty;

            foreach($list as $item) {
                $item->run($modelProperty);
            }

            $propertyList->add($modelProperty);
        }

        return $propertyList;
    }
}