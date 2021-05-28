<?php

namespace Erupt\Foundations;

use Erupt\Foundations\BaseList;
use Erupt\Traits\Resolve;
use Erupt\Interfaces\Resolver;

abstract class ResolverList extends BaseList implements Resolver
{
    use Resolve;
}