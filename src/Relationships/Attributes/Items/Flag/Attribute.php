<?php

namespace Erupt\Relationships\Attributes\Items\Flag;

use Erupt\Relationships\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "name";

    public function __construct(string|array $args)
    {
        $this->takeArgs($args);
    }
}