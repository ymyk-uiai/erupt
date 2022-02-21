<?php

namespace Erupt\Attributes;

use Erupt\Traits\HasParams;
use Erupt\Foundation\BaseListItem;
use Erupt\Attributes\BaseAttributeContainer;
use Erupt\Attributes\Lists\AttributeList;
use Erupt\Attributes\Containers\AttributeContainer;

abstract class BaseAttribute extends BaseListItem
{
    use HasParams;

    protected bool $column = false;

    protected ?string $alias = null;

    protected ?string $schemaCommand = null;

    protected ?string $schemaModifier = null;

    protected string $values = "";

    protected string $validationRules = "";

    protected string $flags = "";

    protected string $factories = "";

    public function getValues(): ?string
    {
        return $this->values;
    }

    public function getValidationRules(): ?string
    {
        return $this->validationRules;
    }

    public function getFlags(): ?string
    {
        return $this->flags;
    }

    public function getFactories(): ?string
    {
        return $this->factories;
    }

    public static function build(string $attr, self $a = null): self
    {
        list($name, $args) = explode(":", $attr.":", 2);

        $product = match ($name) {
            "id" => new Items\Id\Attribute,
            "bigIncrements" => new Items\BigIncrements\Attribute,
            "unsignedBigInteger" => new Items\UnsignedBigInteger\Attribute,
            "string" => new Items\String\Attribute,
            "rememberToken" => new Items\RememberToken\Attribute,
            "timestamp" => new Items\Timestamp\Attribute,
            "timestamps" => new Items\Timestamps\Attribute,
            "has" => new Items\Has\Attribute,
            "belongsTo" => new Items\BelongsTo\Attribute,
            default => new Items\Unknown\Attribute,
        };

        if($a) {
            $args = preg_replace_callback(
                "/({(\w+)})(.*)/",
                function ($matches) use ($a) {
                    return $a->getArg($matches[2]).$matches[3];
                },
                $args
            );
        }

        /*
        if($a) {
            foreach($args as $index => $arg) {
                $args[$index] = preg_replace_callback(
                    "/({(\w+)})(.*)/",
                    function ($matches) use ($a) {
                        return $a->getArg($matches[2]).$matches[3];
                    },
                    $arg
                );
            }
        }
        */

        $product->takeArgs(trim($args, ":"));

        return $product;
    }

    public function isSchemaCommand(): bool
    {
        return !!$this->schemaCommand;
    }

    public function getSchemaCommand(): string
    {
        $args = implode(",", array_map(function ($e) {
            return "'$e'";
        }, array_filter($this->args)));
        return $args ? $this->schemaCommand."(".$args.")" : $this->schemaCommand."()";
    }

    public function isSchemaModifier(): bool
    {
        return !!$this->schemaModifier;
    }

    public function getSchemaModifier(): string
    {
        return $this->schemaModifier;
    }

    public function getArg(string $name): string
    {
        return $this->args[$name];
    }

    public function evaluate(array $args = []): BaseAttributeContainer
    {
        if(!!!$this->alias) {
            $container = new AttributeContainer;
            $list = new AttributeList;
            $list->add($this);
            $container->add($list);
            return $container;
        }

        $ps = explode('&', $this->alias);

        $container = new AttributeContainer;
        foreach($ps as $p) {
            $as = explode('|', $p);
            $list = new AttributeList;
            foreach($as as $a) {
                $list->add(self::build($a, $this));
            }
            $container->add($list);
        }

        return $container->evaluate();
    }

    public function isColumn(): bool
    {
        return $this->column;
    }
}