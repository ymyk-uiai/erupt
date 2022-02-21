<?php

namespace Erupt\Properties;

use Erupt\Foundation\BaseListItem;
use Erupt\Traits\HasParams;
use Erupt\Attributes\BaseAttribute as Attribute;
use Erupt\Values\BaseValue as Value;
use Erupt\Values\Lists\ValueList;
use Erupt\ValidationRules\BaseValidationRule as ValidationRule;
use Erupt\ValidationRules\Lists\ValidationRuleList;
use Erupt\Flags\BaseFlag as Flag;
use Erupt\Flags\Lists\FlagList;
use Erupt\Factories\BaseFactory as Factory;
use Erupt\Factories\Lists\FactoryList;

abstract class BaseProperty extends BaseListItem
{
    use HasParams;

    protected ValueList $values;

    protected ValidationRuleList $validationRules;

    protected FlagList $flags;

    protected FactoryList $factories;

    public function __construct()
    {
        $this->values = new ValueList;
        $this->validationRules = new ValidationRuleList;
        $this->flags = new FlagList;
        $this->factories = new FactoryList;
    }

    public function build(Attribute $attr): void
    {
        $this->buildValues($attr->getValues(), $attr);
        $this->buildValidationRules($attr->getValidationRules(), $attr);
        $this->buildFlags($attr->getFlags(), $attr);
        $this->buildFactories($attr->getFactories(), $attr);
    }

    protected function buildValues(string $values, Attribute $attr): void
    {
        $values = array_filter(explode('|', $values));

        foreach($values as $value) {
            $this->values->add(Value::build($value, $attr));
        }
    }

    protected function buildValidationRules(string $rules, Attribute $attr): void
    {
        $rules = array_filter(explode('|', $rules));

        foreach($rules as $rule) {
            $this->validationRules->add(ValidationRule::build($rule, $attr));
        }
    }

    protected function buildFlags(string $flags, Attribute $attr): void
    {
        $flags = array_filter(explode('|', $flags));

        foreach($flags as $flag) {
            $this->flags->add(Flag::build($flag, $attr));
        }
    }

    protected function buildFactories(string $factories, Attribute $attr): void
    {
        $factories = array_filter(explode('|', $factories));

        foreach($factories as $factory) {
            $this->factories->add(Factory::build($factory, $attr));
        }
    }
}