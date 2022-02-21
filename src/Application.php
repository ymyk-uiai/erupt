<?php

namespace Erupt;

use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Plans\Lists\PlanList;
use Erupt\Models\Lists\ModelList;
use Erupt\Generators\Lists\GeneratorList;
use Erupt\Files\Lists\FileList;
use Erupt\Migrations\Lists\MigrationList;
use Erupt\Events\Lists\EventList;
use Erupt\Generators\BaseGenerator;
use Erupt\Migrations\BaseMigration as Migration;
use Erupt\Events\BaseEvent as Event;
use Erupt\Seeders\Lists\SeederList;
use Erupt\Routes\Lists\RouteList;
use Erupt\AuthProviders\Lists\AuthProviderList;

class Application
{
    protected ModelList $models;

    protected GeneratorList $generators;

    protected FileList $files;

    protected MigrationList $migrations;

    protected EventList $events;

    public function __construct($config)
    {
        $relationships = RelationshipList::build($config["relationships"]);

        $plans = PlanList::build($config["models"], $relationships);

        $models = ModelList::build($plans);

        $this->models = $models;

        //print_r($plans);

        //print_r($models);

        $this->generators = GeneratorList::build();

        $this->files = FileList::build($this, $plans, $relationships);

        //print_r($this->files);

        $this->migrations = MigrationList::build($this, $plans, $relationships);

        //print_r($this->migrations);

        $this->events = EventList::build();

        $this->seeders = new SeederList;

        $this->routes = new RouteList;

        $this->authProviders = new AuthProviderList;
    }

    public function getModels(): ModelList
    {
        return $this->models;
    }

    public function getMigrationGenerator(): BaseGenerator
    {
        return $this->generators->getMigrationGenerator();
    }

    public function getFiles(): FileList
    {
        return $this->files;
    }

    public function getMigrations(): MigrationList
    {
        return $this->migrations;
    }

    public function getMigration(string $fileName): Migration|bool
    {
        foreach($this->migrations as $migration) {
            if($migration->is($fileName)) {
                return $migration;
            }
        }
        return false;
    }

    public function registerEvent(string $event): void
    {
        $this->events->add(EventList::build($event));
    }

    public function dispatchEvents(): void
    {
        foreach($this->events as $event) {
            $this->dispatchEvent($event);
        }
    }

    public function dispatchEvent(Event $event): void
    {
        $event->dispatch();
    }

    public function getSeeders(): SeederList
    {
        return $this->seeders;
    }

    public function getRoutes(): RouteList
    {
        return $this->routes;
    }

    public function getAuthProviders(): AuthProviderList
    {
        return $this->authProviders;
    }
}