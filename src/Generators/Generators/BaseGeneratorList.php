<?php

namespace Erupt\Generators\Generators;

use Erupt\Foundations\Lists\BaseList;
use Erupt\Interfaces\Makers\Items\FileMaker;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Erupt\Specifications\Specifications\Lists\MigrationSpecificationList;

class BaseGeneratorList extends BaseList
{
    public static function build(): Self
    {
        return new Static;
    }

    public function make_file_specs(FileMaker $maker): FileSpecificationList
    {
        $list = new FileSpecificationList;

        foreach($this->list as $generator) {
            $list->add($generator->make_file_specs($maker));
        }

        return $list;
    }

    public function make_migration_specs($model): MigrationSpecificationList
    {
        $list = new MigrationSpecificationList;

        foreach($this->list as $generator) {
            $list->add($generator->make_migration_specs($model));
        }

        return $list;
    }

    //  Unit Type BaseGenerator|BaseGeneratorList
    public function add($generator)
    {
        parent::add($generator);
    }
}