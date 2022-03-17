<?php

namespace Erupt\Traits;

use Erupt\Foundation\Initializer;
use Erupt\Application;
use Erupt\Plans\BasePlan;
use Erupt\Proposals\BaseProposal;
use Erupt\Relationships\BaseRelationship;
use Erupt\Models\BaseModel;
use Erupt\Properties\BaseProperty;
use Erupt\Files\BaseFile;

trait HandleInitialize
{
    protected Application $app;
    protected BasePlan $plan;
    protected BaseProposal $proposal;
    protected BaseRelationship $relationship;
    protected BaseModel $model;
    protected BaseProperty $property;
    protected BaseFile $file;

    public function makeIni(): Initializer
    {
        return new Initializer;
    }

    protected function initialize(Initializer $ini): void
    {
        $vars = $ini->get_obj_vars();
        foreach($vars as $key => $value) {
            if(isset($value)) {
                $this->{$key} = $value;
            } else {
                unset($this->{$key});
            }
        }
    }
}