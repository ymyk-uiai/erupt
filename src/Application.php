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

    protected array $seeder_class = [];

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

        $this->init_event_listeners();
    }

    public function get_models(): ModelList
    {
        return $this->models;
    }

    public function get_model($model_name)
    {
        return $this->models->get($model_name);
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

    protected function init_event_listeners(): void
    {
        $app = $this;

        //  event_name, event_listener
        //
        //  "create_seeder"
        //  ||
        //  "syntax"
        //  "event_listener"

        $this->events = [
            "make_seeder" => function ($seeder_class) use ($app) {
                $app->add_seeder($seeder_class);
            },
            "make_route" => function ($route_name) use ($app) {
                $app->add_route($route_name);
            },
            "make_policy" => function ($policy_key_value) use ($app) {
                $app->add_policy($policy_key_value);
            }
        ];
    }

    public function add_seeder($seeder_class): void
    {
        $this->seeders[] = "$seeder_class::class";
    }

    public function add_route($route_name) : void
    {
        $this->routes[] = $route_name;
    }

    public function add_policy($policy_key_value) : void
    {
        $this->policies[] = $policy_key_value;
    }

    public function implode_seeders(): string
    {
        return implode(",\n", $this->seeders);
    }

    public function implode_routes(): string
    {
        return implode("\n", array_map(function ($route_args) {
            $route_args = array_map("trim", explode(",", $route_args));
            $route_args = array_map(function ($route_arg) {
                return "'{$route_arg}'";
            }, $route_args);
            $route_args = implode(",", $route_args);
            return "Route::resource({$route_args});";
        }, $this->routes));

        return implode("\n", array_map(function ($route_args) {
            $route_args = implode(", ", array_map(function ($route_arg) {
                 return "'".trim($route_arg)."'";
            }, explode(",", $route_args)));
            return "Route::resource({$route_args});";
        }, $this->routes));
    }

    public function implode_policies(): string
    {
        return implode(",\n", array_map(function ($policy_key_value) {
            $policy_key_value = implode(" => ", array_map(function ($arg) {
                return "'".trim($arg)."'";
            }, explode(",", $policy_key_value)));
            return $policy_key_value;
        }, $this->policies));
    }

    public function dispatch($name, $args): void
    {
        $this->events[$name]($args);
    }
}