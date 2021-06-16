<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Interfaces\File;
use Erupt\Interfaces\Migration;
use Erupt\Interfaces\Resolver;
use Erupt\Plans\Properties\Lists\PropertyList;
use Erupt\Models\Values\Lists\ModelValueList;
use Erupt\Models\Properties\Lists\PropertyList as ModelProps;
use Erupt\Foundations\ResolverItem;
use Erupt\Traits\BelongsToApp;
use Erupt\Traits\HasFlags;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Exception;
use Erupt\Models\Values\Items\ClassName\Value as ClassNameValue;

abstract class BaseModel extends ResolverItem implements File, Migration
{
    use BelongsToApp, HasFlags;

    protected ModelValueList $values;

    protected ModelProps $props;

    abstract public function getType(): string;

    public function __construct(Application $app, PropertyList $planProps)
    {
        $this->setApp($app);

        $this->setValues(new ModelValueList);

        $this->setProps(new ModelProps($app, $this, $planProps));
    }

    public static function getDefaultAttributes(string $planProperty): string
    {
        return static::$defaultAttributes[self::getPlanPropertyName($planProperty)] ?? "";
    }

    public static function getDefaultRelationalAttributes(string $modelType): string
    {
        return static::$defaultRelationalAttributes[$modelType] ?? "";
    }

    protected static function getPlanPropertyName(string $planProperty): string
    {
        $attrs = explode('|', $planProperty);

        $firstAttr = explode(':', $attrs[0]);

        return $firstAttr[1] ?? $firstAttr[0];
    }

    public function setValues(ModelValueList $values): void
    {
        $this->values = $values;
    }

    public function getValues(): ModelValueList
    {
        return $this->values;
    }

    public function setProps(ModelProps $props): void
    {
        $this->props = $props;
    }

    public function getProps(): ModelProps
    {
        return $this->props;
    }

    protected function getResolver(string $key, array &$keys): Resolver
    {
        try {
            if($key == "name") {
                array_push($keys, "model");
                array_push($keys, "name");
            }
            return match($key) {
                "name" => $this->getFiles(),
                "values" => $this->getValues(),
                "attributes",
                "props" => $this->getProps(),
                "files" => $this->getFiles(),
                "className" => $this->getValues()->getValue('className'),
                default => throw new Exception($key),
            };
        } catch (Exception $e) {
            echo 'Unknown resolve key: ',  $e->getMessage(), "\n";
        }
    }

    public function evaluate()
    {
        return $this;
    }

    protected function getFiles(): FileSpecificationList
    {
        return $this->app->getFiles()->filter($this);
    }

    public function getMigration(): string
    {
        $result = [];

        return implode(";\n", $result);
    }
}