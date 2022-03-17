<?php

namespace Erupt;

use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Plans\Lists\PlanList;
use Erupt\Models\Lists\ModelList;
use Erupt\Models\BaseModelList;
use Erupt\Models\BaseModel;
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
use Erupt\Foundation\Initializer;

class Application
{
    protected ModelList $models;

    protected FileList $files;

    protected EventList $events;

    protected static array $accessKeys = ['app', 'application'];

    public function __construct($config)
    {
        $ini = new Initializer;
        $ini->add($this);

        //print_r($ini);

        $relationships = RelationshipList::build($ini, implode('||', $config['relationships']));
        //print_r($relationships);
        $this->relationships = $relationships;

        $plans = $this->completePlans($config['plans'], $relationships);
        //print_r($plans);

        $plans = PlanList::build($ini, $plans);
        //print_r($plans);
        $this->plans = $plans;

        $models = ModelList::build($ini, $plans);
        print_r($models->getModel('user'));
        $this->models = $models;

        $files = FileList::build($ini, $plans, $relationships);
        //print_r($files);
        $this->files = $files;
    }

    protected function completePlans(array $plans, RelationshipList $rels): string
    {
        foreach($plans as $name => $data) {
            $plans[$name]['props'] = array_merge($plans[$name]['props'], $rels->getRelationalProposals($name));
        }

        $results = [];

        foreach($plans as $name => $value) {
            $proposals = array_map(function ($proposal) {
                if(preg_match("/^[a-zA-Z\\\\]+:{2}/", $proposal)) {
                    return $proposal;
                } else {
                    return "Proposal::".$proposal;
                }
            }, $value['props']);
            $proposals = implode('||', $proposals);
            $results[] = ucfirst($name).':::'.$proposals;
        }
        //print_r($results);
        return implode('|||', $results);
    }

    public function getModels(): BaseModelList
    {
        return $this->models;
    }

    public function getModel(string $name): BaseModel
    {
        return $this->models->getModel($name);
    }

    public function getFiles(): FileList
    {
        return $this->files;
    }
}