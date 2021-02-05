<?php

namespace Erupt;

use Erupt\Models\Models\Lists\ModelList;
use Erupt\Generators\Generators\Lists\GeneratorList;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Erupt\Specifications\Specifications\Lists\MigrationSpecificationList;
use Erupt\Relationships\Relationships\Lists\RelationshipList;
use Erupt\Plans\Plans\Lists\PlanList;
use Erupt\Generators\Generators\BaseGenerator;
use Erupt\Specifications\Makers\Lists\MakerList;
use Erupt\Generators\Generators\Items\LaravelGenerator;

class Application
{
    protected ModelList $models;

    protected GeneratorList $generators;

    protected FileSpecificationList $file_specs;

    protected MigrationSpecificationList $migration_specs;

    protected array $events;

    public function __construct($config)
    {
        $relationships = RelationshipList::build($config, $this);

        $plans = PlanList::build($config, $relationships);

        $this->models = ModelList::build($plans, $relationships, $this);

        $this->generators = GeneratorList::build();

        $this->register_generator(new LaravelGenerator);

        $makers = MakerList::build($this->models, $relationships);

        $this->file_specs = FileSpecificationList::build($makers, $this);

        $this->migration_specs = MigrationSpecificationList::build($makers, $this);
    }

    public function get_models(): ModelList
    {
        return $this->models;
    }

    public function get_generators(): GeneratorList
    {
        return $this->generators;
    }

    public function register_generator(BaseGenerator $generator)
    {
        $this->generators->add($generator);
    }

    public function get_file_specs(): FileSpecificationList
    {
        return $this->file_specs;
    }

    public function get_migration_specs(): MigrationSpecificationList
    {
        return $this->migration_specs;
    }
}