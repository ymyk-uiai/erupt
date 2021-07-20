<?php

namespace Erupt\Models\Models;

use Erupt\Application;
use Erupt\Foundations\ResolverItemBelongsToApp;
use Erupt\Interfaces\File;
use Erupt\Interfaces\Migration;
use Erupt\Interfaces\Resolver;
use Erupt\Models\ModelFlags\Lists\ModelFlagList as FlagList;
use Erupt\Models\ModelValues\Lists\ModelValueList as ValueList;
use Erupt\Models\Properties\Lists\PropertyList;
use Erupt\Models\ModelValues\Items\ClassName\Value as ClassNameValue;
use Erupt\Plans\Properties\Lists\PropertyList as PlanPropertyList;
use Erupt\Specifications\Specifications\Lists\FileSpecificationList;
use Erupt\Traits\HasModelFlagList as HasFlagList;
use Erupt\Traits\HasModelValueList as HasValueList;
use Erupt\Traits\HasPropertyList;
use Erupt\Models\ModelValues\BaseModelValue as ModelValue;
use Erupt\Models\ModelFlags\BaseModelFlag as ModelFlag;
use Exception;

abstract class BaseModel extends ResolverItemBelongsToApp implements File, Migration
{
    use HasValueList, HasFlagList, HasPropertyList;

    abstract public function getType(): string;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->values = new ValueList($app, $this);
        $this->flags = new FlagList($app, $this);
        $this->properties = new PropertyList($app, $this);
    }

    public function build(PlanPropertyList $planProps): void
    {
        $this->properties->build($planProps);
    }

    public function build2($builder): void
    {
        if($builder instanceof ModelValue) {
            $this->updateModelValues($builder);
        } else if($builder instanceof ModelFlag) {
            $this->updateModelFlags($builder);
        } else {
            print_r(get_class($builder));
        }
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
                "props" => $this->getProperties(),
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