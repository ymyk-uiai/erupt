<?php

namespace Erupt\Traits;

use Erupt\Application;

trait BelongsToApp
{
    protected Application $app;

    public function setApplication(Application $app): void
    {
        $this->app = $app;
    }

    public function getApplication(): Application
    {
        return $this->app;
    }
}