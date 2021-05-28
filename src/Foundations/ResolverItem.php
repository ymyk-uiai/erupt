<?php

namespace Erupt\Foundations;

use Erupt\Foundations\BaseItem;
use Erupt\Traits\Resolve;
use Erupt\Interfaces\Resolver;

abstract class ResolverItem extends BaseItem implements Resolver
{
    use Resolve;
}