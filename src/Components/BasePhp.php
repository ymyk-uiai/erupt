<?php

namespace Erupt\Components;

abstract class BasePhp extends BaseComponent
{
    protected ?string $extends = null;

    protected array $implements = [];

    protected array $traits = [];

    protected array $aliases = [];

    protected array $components = [];

    protected array $events = [];
}