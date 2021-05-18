<?php

namespace Erupt\Models\Properties;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Models\Properties\Items\Property as ModelProperty;
use Erupt\Models\Properties\Items\RelationshipProperty as ModelRelationshipProperty;
use Erupt\Models\Properties\Lists\PropertyList as ModelProperties;
use Erupt\Plans\Methods\Containers\UpdaterContainer;
use Erupt\Plans\Properties\Items\Property as PlanProperty;
use Erupt\Plans\Properties\Items\RelationshipProperty as PlanRelationshipProperty;
use Erupt\Plans\Properties\Lists\PropertyList as PlanProperties;
use Erupt\Plnas\Properties\Lists\PlanPropertyList;

abstract class BasePropertyList extends BaseList
{
    public static function build(PlanProperties $planProperties, $app, $model): ModelProperties
    {
        $propertyList = new ModelProperties;

        $rootContainer = new UpdaterContainer;

        foreach($planProperties as $planProperty) {

            $container = new UpdaterContainer;

            foreach($planProperty->get_attributes() as $attribute) {

                $sbj = $attribute->run();

                if($planProperty instanceof PlanRelationshipProperty) {
                    $sbj->setRelationship(true);
                } else {
                    $sbj->setRelationship(false);
                }

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

            $modelProp = match($list->getRelationship()) {
                true => ModelRelationshipProperty::build($app),
                false => ModelProperty::build($app),
            };

            foreach($list as $item) {
                $item->run($modelProp);
            }

            $propertyList->add($modelProp->setModelFlags($model));
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