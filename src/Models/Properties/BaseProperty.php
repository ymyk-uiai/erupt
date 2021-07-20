<?php

namespace Erupt\Models\Properties;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToModel;
use Erupt\Interfaces\Resolver;
use Erupt\Models\Factories\BaseFactory as Factory;
use Erupt\Models\PropertyFlags\BasePropertyFlag as PropertyFlag;
use Erupt\Models\PropertyValues\BasePropertyValue as PropertyValue;
use Erupt\Models\ValidationRules\BaseValidationRule as ValidationRule;
use Erupt\Models\Factories\Lists\FactoryList;
use Erupt\Models\PropertyFlags\Lists\PropertyFlagList as FlagList;
use Erupt\Models\PropertyValues\Lists\PropertyValueList as ValueList;
use Erupt\Models\ValidationRules\Lists\ValidationRuleList;
use Erupt\Models\Values\Items\Value\Value;
use Erupt\Models\Models\BaseModel as Model;
use Erupt\Traits\HasFactoryList;
use Erupt\Traits\HasPropertyFlagList as HasFlagList;
use Erupt\Traits\HasPropertyValueList as HasValueList;
use Erupt\Traits\HasValidationRuleList;
use Exception;

abstract class BaseProperty extends ResolverItemBelongsToModel
{
    use HasValueList, HasFlagList, HasValidationRuleList, HasFactoryList;

    public function __construct(Application $app, Model $model)
    {
        parent::__construct($app, $model);

        $this->values = new ValueList($app, $model, $this);
        $this->flags = new FlagList($app, $model, $this);
        $this->validationRules = new ValidationRuleList($app, $model, $this);
        $this->factories = new FactoryList($app, $model, $this);
    }

    protected function makeBuilder($bldr)
    {
        $builder = new $bldr[0]($this->app, $this->model, $this);
        $builder->build($bldr[1]);
        return $builder;
    }

    public function build($builder): void
    {
        if($builder instanceof PropertyValue) {
            $this->updatePropertyValues($builder);
        } else if($builder instanceof PropertyFlag) {
            $this->updatePropertyFlags($builder);
        } else if($builder instanceof ValidationRule) {
            $this->updateValidationRules($builder);
        } else if($builder instanceof Factory) {
            $this->updateFactories($builder);
        } else {
            print_r(get_class($builder));
        }
    }

    public function getName(): string
    {
        return $this->values->get('name');
    }

    public function complete(): void
    {
        /*
        $defaults = $this->getModel()->getDefaults($this->getName());

        foreach($defaults as $default) {
            $this->build($default);
        }
        */

        $defaults = $this->getDefaults();

        foreach($defaults as $default) {
            $this->build($this->makeBuilder($default));
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
                "relationshipArgs" => $this->getPropertyValues()->getValue($key),
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