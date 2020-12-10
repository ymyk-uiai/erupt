<?php

namespace Erupt;

use Erupt\Relationships\Lists\Relationships\RelationshipList;
use Erupt\Plans\Lists\Plans\PlanList;
use Erupt\Models\Constructors\Lists\Models\ModelList;
use Erupt\Migrations\Lists\Migrations\MigrationList;
use Erupt\Generators\LaravelGenerator\LaravelGenerator;
use Erupt\Generators\NuxtGenerator\NuxtGenerator;

class Application
{
    protected $models;

    protected $migrations;

    // protected array $generatorStack = [];

    protected array $events;

    public function __construct($config)
    {
        $server = new LaravelGenerator;

        $front = new NuxtGenerator;

        $this->server = $server;

        $this->front = $front;

        $this->events["test"] = function ($args) {
            print_r("\n$args\n");
        };

        $relationships = RelationshipList::build($config);

        //print_r($relationships);

        $plans = PlanList::build($config, $relationships);

        //print_r($plans);

        $this->models = ModelList::build($plans, $relationships, $server, $front);

        //$this->migrations = new MigrationList($plans, $relationships);
    }

    public function getModels()
    {
        return $this->models;
    }

    public function getMigrations()
    {
        return $this->migrations;
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