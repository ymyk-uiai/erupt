<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverList;
use Erupt\Traits\BelongsToApp;
use Erupt\Application;

abstract class ResolverListBelongsToApp extends ResolverList
{
    use BelongsToApp;

    public function __construct(Application $app)
    {
        $this->setApplication($app);
    }

    public function makeEmpty(): Static
    {
        return new Static($this->app);
    }

    public function startDebug(): void
    {
        unset($this->app);

        foreach($this->list as $item) {
            $item->startDebug();
        }
    }
}