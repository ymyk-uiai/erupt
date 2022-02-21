<?php

namespace Erupt\Generators;

use Erupt\Foundation\BaseList;
use Erupt\Generators\Items\Laravel\FileGenerator;
use Erupt\Generators\Items\Laravel\MigrationGenerator;

abstract class BaseGeneratorList extends BaseList
{
    public static function build(): self
    {
        $product = new static;

        $product->add(new FileGenerator);
        $product->add(new MigrationGenerator);

        return $product;
    }

    public function getFileGenerator(): BaseGenerator
    {
        foreach($this as $generator) {
            if($generator->isFile()) {
                return $generator;
            }
        }
    }

    public function getMigrationGenerator(): BaseGenerator
    {
        foreach($this as $generator) {
            if($generator->isMigration()) {
                return $generator;
            }
        }
    }

    public function add(BaseGenerator|self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseGenerator|self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}