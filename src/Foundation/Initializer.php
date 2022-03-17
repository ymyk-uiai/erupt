<?php

namespace Erupt\Foundation;

use Erupt\Application;
use Erupt\Plans\BasePlan;
use Erupt\Proposals\BaseProposal;
use Erupt\Relationships\BaseRelationship;
use Erupt\Models\BaseModel;
use Erupt\Properties\BaseProperty;
use Erupt\Files\BaseFile;

class Initializer
{
    protected ?Application $app = null;
    protected ?BasePlan $plan = null;
    protected ?BaseProposal $proposal = null;
    protected ?BaseRelationship $relationship = null;
    protected ?BaseModel $model = null;
    protected ?BaseProperty $property = null;
    protected ?BaseFile $file = null;

    public static function init($instance): self
    {
        $ini = new self;
        return $ini->add($instance);
    }

    public function get_obj_vars(): array
    {
        return get_object_vars($this);
    }

    public function update($instance): self
    {
        return $this->duplicate()->add($instance);
    }

    public function duplicate(): self
    {
        $ini = new self;

        $vars = get_obj_vars($this);
        foreach($vars as $var) {
            $ini->add($var);
        }

        return $ini;
    }

    public function add($instance): self
    {
        switch(get_class($instance)) {
            case $instance instanceof Application:
                $this->app = $instance;
                break;
            case $instance instanceof BasePlan:
                $this->plan = $instance;
                break;
            case $instance instanceof BaseProposal:
                $this->proposal = $instance;
                break;
            case $instance instanceof BaseRelationship:
                $this->relationship = $instance;
                break;
            case $instance instanceof BaseModel:
                $this->model = $instance;
                break;
            case $instance instanceof BaseProperty:
                $this->prop = $instance;
                break;
            case $instance instanceof BaseFile:
                $this->file = $instance;
                break;
            default:
                throw new \Exception(get_class($instance));
        }
        return $this;
    }
}