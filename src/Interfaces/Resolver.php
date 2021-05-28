<?php

namespace Erupt\Interfaces;

interface Resolver
{
    public function resolve(string|array $keys): Self;

    public function evaluate();
}