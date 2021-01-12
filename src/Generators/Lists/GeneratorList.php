<?php

namespace Erupt\Generators\Lists;

use Erupt\Generators\Bases\BaseGeneratorList;
use Erupt\Specifications\Specifications\Lists\SpecificationList;
use Erupt\Interfaces\FileMaker;

class GeneratorList extends BaseGeneratorList
{
    public function make_file_specifications(FileMaker $maker): SpecificationList
    {
        $list = new SpecificationList;

        foreach($this->list as $generator) {
            $list->add($generator->make_file_specifications($maker));
        }

        return $list;
    }

    public function make_migration_specifications($model): SpecificationList
    {
        $list = new SpecificationList;

        foreach($this->list as $generator) {
            $list->add($generator->make_migration_specifications($model));
        }

        return $list;
    }
}