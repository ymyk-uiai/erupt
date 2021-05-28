<?php

namespace Erupt\Traits;

use Erupt\Models\Factories\Lists\FactoryList;

trait HasFactories
{
    protected FactoryList $factories;

    public function setFactoryList(FactoryList $factories): void
    {
        $this->factories = $factories;
    }

    public function getFactoryList(): FactoryList
    {
        return $this->factories;
    }
}