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
        $this->setApp($app);
    }
}