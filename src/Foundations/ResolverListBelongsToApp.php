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
        $this->setApp($app);
    }

    public function empty(): Self
    {
        
    }
}