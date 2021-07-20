<?php

namespace Erupt\Traits;

use Erupt\Models\Factories\BaseFactoryList as FactoryList;
use Erupt\Models\Factories\BaseFactory as Factory;

trait HasFactoryList
{
    protected FactoryList $factories;

    public function setFactories(FactoryList $factories): void
    {
        $this->factories = $factories;
    }

    public function getFactories(): FactoryList
    {
        return $this->factories;
    }

    public function updateFactories(Factory $factory): void
    {
        $this->factories->add($factory);
    }
}