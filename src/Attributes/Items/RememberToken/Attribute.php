<?php

namespace Erupt\Attributes\Items\RememberToken;

use Erupt\Attributes\BaseAttribute;

class Attribute extends BaseAttribute
{
    protected string $params = "";

    protected ?string $alias = "string:remember_token,100";

    protected ?string $schemaCommand = "rememberToken";
}