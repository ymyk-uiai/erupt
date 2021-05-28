<?php

namespace Erupt\Traits;

trait HasFlags
{
    protected array $flags = [];

    public function setFlag(string $key, bool $value): void
    {
        $this->flags[$key] = $value;
    }

    public function getFlag(string $key): bool
    {
        return $this->flags[$key] ?? false;
    }
}