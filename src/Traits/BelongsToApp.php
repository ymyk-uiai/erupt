<?php

namespace Erupt\Traits;

use Erupt\Application;

trait BelongsToApp
{
    protected Application $app;

    public function setApp(Application $app): void
    {
        $this->app = $app;
    }

    public function getApp(): Application
    {
        return $this->app;
    }
}