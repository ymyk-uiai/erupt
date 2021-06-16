<?php

namespace Erupt;

use Erupt\Generators\Generators\BaseGenerator as Generator;
use Erupt\Generators\Generators\Items\LaravelGenerator;
use Erupt\Generators\Generators\Lists\GeneratorList;
use Erupt\Models\Models\Lists\ModelList;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Plans\Plans\Lists\PlanList;
use Erupt\Relationships\Relationships\Lists\RelationshipList;
use Erupt\Specifications\Makers\Lists\MakerList;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Erupt\Specifications\Specifications\Lists\MigrationSpecificationList;
use Erupt\Foundations\ResolverItem;
use Erupt\Interfaces\Resolver;

class Application extends ResolverItem
{
    protected ModelList $models;

    protected RelationshipList $relationships;

    protected GeneratorList $generators;

    protected FileSpecificationList $file_specs;

    protected MigrationSpecificationList $migrations;

    protected array $events;

    protected array $seeders = [];

    protected array $routes = [];

    protected array $policies = [];

    public function __construct($config)
    {
        $relationships = new RelationshipList($this, $config);

        //print_r($relationships);

        $plans = new PlanList($config['models'], $relationships);

        $this->models = new ModelList($this, $plans, $relationships);
        //  $this->models = $plans->makeModels($this);
        //  $this->migrations = $plans->makeMigrations()

        $this->generators = GeneratorList::build();

        $this->registerGenerator(new LaravelGenerator);

        $this->setFiles($relationships);

        $this->setMigrations($relationships, $plans);

        $this->init_event_listeners();
    }

    public function getModels(): ModelList
    {
        return $this->models;
    }

    public function getModel(string $modelType): Model
    {
        return $this->models->get($modelType);
    }

    public function getGenerators(): GeneratorList
    {
        return $this->generators;
    }

    public function registerGenerator(Generator $generator): void
    {
        $this->generators->add($generator);
    }

    public function setFiles(RelationshipList $relationships): void
    {
        $makers = MakerList::build($this->models, $relationships);

        $this->files = FileSpecificationList::build($makers, $this);
    }

    public function getFiles(): FileSpecificationList
    {
        return $this->files;
    }

    public function unsetFiles(): void
    {
        unset($this->files);
    }

    public function setMigrations(RelationshipList $relationships, $plans): void
    {
        $makers = MakerList::build($this->models, $relationships);

        $this->migrations = MigrationSpecificationList::build($makers, $this, $plans);
    }

    public function getMigrations(): MigrationSpecificationList
    {
        return $this->migrations;
    }

    public function unsetMigrations(): void
    {
        unset($this->migrations);
    }

    public function set_schema_methods_test($plan): void
    {
        $schema_methods = new SchemaMethodContainer;

        foreach($plan->get_properties() as $property) {
            $schema_methods->add($property->get_methods());
        }

        $this->schema_methods_test = $schema_methods;
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

    protected function getResolver(string $key, array &$keys): Resolver
    {
        try {
            return match($key) {
                "models" => $this->getModels(),
                default => throw new Exception($key),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ',  $e->getMessage(), "\n";
        }
    }

    public function evaluate()
    {
        return $this;
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