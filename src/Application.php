<?php

namespace Erupt;

use Erupt\Relationships\Lists\Relationships\RelationshipList;
use Erupt\Plans\Lists\Plans\PlanList;
use Erupt\Models\Constructors\Lists\Models\ModelList;
use Erupt\Migrations\Lists\Migrations\MigrationList;
use Erupt\Generators\LaravelGenerator\LaravelGenerator;
use Erupt\Generators\NuxtGenerator\NuxtGenerator;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Specifications\Specifications\Lists\SpecificationList;
use Erupt\Specifications\Makers\Lists\FileMakerList;
use Erupt\Specifications\Makers\Lists\MigrationMakerList;
use Erupt\Abstracts\Foundations\GenericList;
use Erupt\Generators\Lists\GeneratorList;
use Erupt\Interfaces\MigrationMaker;
use Erupt\Interfaces\FileMaker;

class Application
{
    protected $models;

    protected FileList $files;

    protected GeneratorList $generators;

    protected array $events;

    protected SpecificationList $file_specs;

    protected SpecificationList $migration_specs;

    public function __construct($config)
    {
        $server = new LaravelGenerator;

        $front = new NuxtGenerator;

        $this->server = $server;

        $this->front = $front;

        $this->files = new FileList;

        $this->generators = new GeneratorList;

        $this->generators->add(new LaravelGenerator);

        $this->events["test"] = function ($args) {
            print_r("\n$args\n");
        };

        $relationships = RelationshipList::build($config, $this);

        $plans = PlanList::build($config, $relationships);

        $this->models = ModelList::build($plans, $relationships, $server, $front, $this);

        $file_makers = $this->make_file_makers($this->models, $relationships);

        $migration_makers = $this->make_migration_makers($this->models, $relationships);

        $this->file_specs = $this->make_file_specifications($file_makers);

        $this->migration_specs = $this->make_migration_specifications($migration_makers);
    }

    public function getModels()
    {
        return $this->models;
    }

    public function getMigrations()
    {
        return $this->migrations;
    }

    public function set_generators(GeneratorList $generators)
    {
        return $this->generators = $generators;
    }

    public function get_generators(): GeneratorList
    {
        return $this->generators;
    }

    public function get_files(): FileList
    {
        return $this->files;
    }

    protected function makeGeneratorList($config)
    {
        $builder = new GeneratorListBuilder();

        return $builder->build($config);
    }

    protected function makeRelationshipList($config)
    {
        $builder = new RelationshipListBuilder();

        return $builder->build($config);
    }

    protected function makePlanList($config, $relationships)
    {
        $builder = new PlanListBuilder();

        return $builder->build($config, $relationships);
    }

    protected function makeModelList($plans, $relationships, $server, $front)
    {
        $builder = new ModelListBuilder();

        $model_list = $builder->build($plans, $relationships, $server, $front);

        foreach($model_list as $model) {
            foreach($model->getRelationships() as $relationship) {
                $name = $relationship->getName();

                $instance = $model_list->getModel($name);

                $relationship->setInstance($instance);
            }
        }

        return $model_list;
    }

    protected function make_file_makers($models, $relationships): FileMakerList
    {
        $list = new GenericList;
        $makers = new FileMakerList;

        $list->add($models);
        $list->add($relationships);

        foreach($list as $item) {
            if($item instanceof FileMaker) {
                $makers->add($item);
            }
        }

        return $makers;
    }

    protected function make_file_specifications($list): SpecificationList
    {
        $specs = new SpecificationList;

        foreach($list as $item) {
            $specs->add($this->generators->make_file_specifications($item));
        }

        return $specs;
    }

    protected function make_migration_makers($models, $relationships): MigrationMakerList
    {
        $list = new GenericList;
        $makers = new MigrationMakerList;

        $list->add($models);
        $list->add($relationships);

        foreach($list as $item) {
            if($item instanceof MigrationMaker) {
                $makers->add($item);
            }
        }

        return $makers;
    }

    protected function make_migration_specifications($list): SpecificationList
    {
        $specs = new SpecificationList;

        foreach($list as $item) {
            $specs->add($item->make_migration_specification());
        }

        return $specs;
    }

    protected function get_file_specs(): SpecificationList
    {
        return $this->file_specs;
    }

    protected function get_migration_specs(): SpecificationList
    {
        return $this->migration_specs;
    }

    protected function makeMigrationList($plans, $relationships)
    {
        $builder = new MigrationListBuilder();

        return $builder->build($plans, $relationships);
    }

    public function getComponent($name)
    {
        return __DIR__."/Generators/components/$name.txt";
    }

    public function getCommandSeeds()
    {
        $result = [];

        foreach($this->models as $model) {
            $commandSeeds = $model->getCommandSeeds($this);
            $result = array_merge($result, $commandSeeds);
        }

        return $result;
    }

    public function dispatch($event)
    {
        $event = $this->parseEvent($event);

        if(array_key_exists($event[1], $this->events)) {
            $this->events[$event[1]]($event[2]);
        }
    }

    protected function parseEvent($event)
    {
        preg_match("/^(\w+):([\w_,]+)?/", $event, $matches);

        return $matches;
    }
}