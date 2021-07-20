<?php

namespace Erupt\Foundations;

use Erupt\Foundations\ResolverItem;
use Erupt\Traits\BelongsToApp;
use Erupt\Application;

abstract class ResolverItemBelongsToApp extends ResolverItem
{
    use BelongsToApp;

    public function __construct(Application $app)
    {
        $this->setApplication($app);
    }

    public function startDebug(): void
    {
        unset($this->app);

        foreach($this as $value) {
            if(is_object($value) && method_exists($value, 'startDebug')) {
                $value->startDebug();
            }
        }
    }
}