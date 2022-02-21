<?php

namespace Erupt\Events\Items\Seeder;

use Erupt\Events\BaseEvent;
use Erupt\Seeders\BaseSeeder as Seeder;

class Event extends BaseEvent
{
    public function dispatch(): void
    {
        $this->app->seeders->add($this->makeSeeder());
    }

    protected function makeSeeder(): Seeder
    {
        return Seeder::build($this->args);
    }
}