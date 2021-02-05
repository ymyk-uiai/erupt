<?php

namespace Erupt\Specifications\Specifications\Lists;

use Erupt\Specifications\Specifications\BaseSpecificationList;
use Erupt\Specifications\Makers\Lists\MakerList;
use Erupt\Application;
use Erupt\Specifications\Makers\Lists\MigrationMakerList;

class MigrationSpecificationList extends BaseSpecificationList
{
    public static function build(MakerList $makers, Application $app): Self
    {
        $migration_makers = MigrationMakerList::filter($makers);

        $specs = new Self;

        foreach($migration_makers as $migration_maker) {
            $specs->add($app->get_generators()->make_migration_specs($migration_maker));
        }

        return $specs;
    }
}