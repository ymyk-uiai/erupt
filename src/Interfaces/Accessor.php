<?php

namespace Erupt\Interfaces;

interface Accessor
{
    public static function getAccessKeys(): array;

    public function access(string $keys, int $index): Accessor;
}