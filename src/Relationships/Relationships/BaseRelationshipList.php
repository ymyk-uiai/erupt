<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Application;
use Erupt\Traits\HasList;
use ReflectionClass;
use Erupt\Relationships\Relationships\Lists\{NormalOneToManyList, MorphOneToManyList};
use Exception;
use IteratorAggregate;
use Erupt\Foundations\BaseIterator;

abstract class BaseRelationshipList implements IteratorAggregate
{
    use HasList;

    public function getIterator()
    {
        return new BaseIterator($this->list);
    }

    public static function empty(): Static
    {
        $reflection = new ReflectionClass(BaseRelationshipList::class);
        return $reflection->newInstanceWithoutConstructor();
    }

    public function __construct(Application $app, array $config)
    {
        $relationshipPlans = $config["relationships"] ?? [];

        foreach($relationshipPlans as $index => $relationshipPlan) {
            $relationship = $this->parseRelationship($relationshipPlan);

            $this->add(match($relationship["type"]) {
                "normalOneToMany" => new NormalOneToManyList($index, $relationship),
                "morphOneToMany" => new MorphOneToManyList($index, $relationship),
                default => throw new Exception($relationship["type"]),
            });

            /*
            try {
                $this->add(match($relationship["type"]) {
                    "normalOneToMany" => new NormalOneToManyList($index, $relationship),
                    "morphOneToMany" => new MorphOneToManyList($index, $relationship),
                    default => throw new Exception($relationship["type"]),
                });
            } catch (Exception $e) {
                echo 'Unknown relationship type: ', $e->getMessage(), "\n";
            }
            */
        }
    }

    protected function parseRelationship(string $relationshipPlan): array
    {
        $relationship = [];

        $arg = "[a-zA-Z0-9_]+";
        $args = "${arg}(?:,$arg)*";
        $attrName = "[a-zA-Z0-9_]+";
        $attr = "${attrName}(?::${args})?";
        $attrs = "${attr}(?:|${attr})*";
        $modelType = "[a-zA-Z0-9_]+";
        $model = "${modelType}(?:#${attrs})?";
        $models = "${model}(?:&${model})*";

        $lhs = "(?P<lhs>(?P<lhsType>[OM])\((?P<lhsBody>${models})\))";
        $rhs = "(?P<rhs>(?P<rhsType>[OM])\((?P<rhsBody>${models})\))";

        $pattern = "/${lhs}${rhs}/";

        try {
            if(preg_match($pattern, $relationshipPlan, $matches) === 1) {
                //
            } else {
                throw new Exception($relationshipPlan);
            }
        } catch (Exceptoin $e) {
            echo 'Invalid relationship', $e->getMessage(), "\n";
        }

        preg_match($pattern, $relationshipPlan, $matches);

        preg_match("/${models}/", $matches['lhsBody'], $lhs);
        preg_match("/${models}/", $matches['rhsBody'], $rhs);

        $relationship = [
            "lhs" => [
                "type" => $matches['lhsType'],
                "modelCount" => count($this->parseModels($matches['lhsBody'])),
                "models" => $this->parseModels($matches['lhsBody'])
            ],
            "rhs" => [
                "type" => $matches['rhsType'],
                "modelCount" => count($this->parseModels($matches['rhsBody'])),
                "models" => $this->parseModels($matches['rhsBody'])
            ],
        ];

        $relationship["type"] = $this->getRelationshipType($relationship);

        return $relationship;
    }

    protected function parseModels(string $body): array
    {
        $result = [];

        $models = explode('&', $body);

        foreach($models as $model) {
            $exploded = explode('#', $model);
            $result[] = [
                "type" => $exploded[0],
                "attrs" => $this->parseAttrs($exploded[1] ?? ""),
            ];
        }

        if(count($result) > 0) {
            return $result;
        } else {
            throw new Error("no models");
        }
    }

    protected function parseAttrs(string $attrs): array
    {
        $result = [];

        $attrs = array_filter(explode('|', $attrs));

        foreach($attrs as $attr) {
            $exploded = explode(':', $attr);
            $result[$exploded[0]] = $exploded[1] ?? "";
        }
        return empty($result) ? [] : $result;
    }

    protected function getRelationshipType(array $relationship): string
    {
        $lhs = $relationship['lhs'];
        $rhs = $relationship['rhs'];

        $prefix = $lhs['modelCount'] > 1 ? 'morph' : 'normal';

        $lhs = $lhs["type"] == "O" ? "One" : "Many";
        $rhs = $rhs["type"] == "O" ? "One" : "Many";

        return $prefix.$lhs.'To'.$rhs;
    }

    public function add(BaseRelationship|BaseRelationshipList $item): void
    {
        if($item instanceof BaseRelationshipList) {
            foreach($item as $i) {
                $this->addItem($i);
            }
        } else {
            $this->addItem($item);
        }
    }
}