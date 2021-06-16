<?php

namespace Erupt\Models\Properties;

use Erupt\Application;
use Erupt\Foundations\ResolverItem;
use Erupt\Models\Values\Lists\PropValueList as ValueList;
use Erupt\Models\Values\Items\Value\Value;
use Erupt\Models\ValidationRules\Lists\ValidationRuleList;
use Erupt\Models\Factories\Lists\FactoryList;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\BelongsToModel;
use Erupt\Traits\HasFlags;
use Erupt\Interfaces\Resolver;
use Exception;

abstract class BaseProperty extends ResolverItem
{
    use BelongsToApp,
        BelongsToModel,
        HasFlags;

    protected ValueList $values;
    
    protected ValidationRuleList $validationRules;

    protected FactoryList $factories;

    public function __construct($app, $model)
    {
        $this->setApp($app);

        $this->setModel($model);

        $this->setValues(ValueList::empty());

        $this->setValidationRules(ValidationRuleList::empty());

        $this->setFactories(FactoryList::empty());
    }

    public function getName(): string
    {
        return $this->values->get('name');
    }

    public function setValues(ValueList $values): void
    {
        $this->values = $values;
    }

    public function getPropValues(): ValueList
    {
        return $this->values;
    }

    public function setValidationRules(ValidationRuleList $validationRules): void
    {
        $this->validationRules = $validationRules;
    }

    public function getValidationRules(): ValidationRuleList
    {
        return $this->validationRules;
    }

    public function setFactories(FactoryList $factories): void
    {
        $this->factories = $factories;
    }

    public function getFactories(): FactoryList
    {
        return $this->factories;
    }

    public function finish(string $propName): void
    {
        $defaultFlags = $this->getModel()->getDefaultFlags($propName);

        foreach($defaultFlags as $name => $bool) {
            $this->setFlag($name, $bool);
        }

        $defaultFlags = $this->getDefaultFlags();

        foreach($defaultFlags as $name => $bool) {
            $this->setFlag($name, $bool);
        }
    }

    public function update(array $data): void
    {
        foreach($data as $key => $value) {
            match($key) {
                "values" => $this->getPropValues()->update($value),
                "validationRules" => 0,
                "factories" => $this->getFactories()->update($value),
                "flags" => $this->updateFlags($value),
            };
        }
    }

    protected function updateFlags(array $flags): void
    {
        foreach($flags as $flag) {
            $this->flags[$flag] = true;
        }
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        try {
            return match($key) {
                "name",
                "columnType",
                "valueType",
                "relationshipMethodName",
                "relationshipName",
                "relationshipArgs" => $this->getPropValues()->getValue($key),
                "factory" => $this->getFactories()->getResult(),
                "validationRules" => $this->getValidationRules(),
                default => throw new Exception($key),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ', $e->getMessage(), "\n";
        }
    }

    public function evaluate()
    {
        return $this;
    }
}