<?php

namespace Erupt\Language;

class Evaluator
{
    protected $constructs = [];

    protected $functions = [];

    protected $reserved = [];

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

        $eva = $this;

        $this->functions["print"] = function ($args, $scope) use ($eva) {
            $format = array_shift($args);

            foreach($args as $arg) {
                if($arg["type"] == "value") {
                    $format["value"] = preg_replace("/{}/", $arg["value"], $format["value"], 1);
                } else if ($arg["type"] == "word") {
                    $format["value"] = preg_replace("/{}/", $eva->resolve($arg["name"], $scope, $eva->app), $format["value"], 1);
                }
            }

            $scope->write($format["value"]);
        };

        $this->functions["preprint"] = function ($args, $scope) use ($eva) {
            $format = array_shift($args);

            foreach($args as $arg) {
                if($arg["type"] == "value") {
                    $format["value"] = preg_replace("/{}/", $arg["value"], $format["value"], 1);
                } else if($arg["type"] == "word") {
                    $format["value"] = preg_replace("/{}/", $eva->resolve($arg["name"], $scope, $eva->app), $format["value"], 1);
                }
            }

            $scope->write($format["value"], "pre");
        };

        $this->functions["postprint"] = function ($args, $scope) use ($eva) {
            $format = array_shift($args);

            foreach($args as $arg) {
                if($arg["type"] == "value") {
                    $format["value"] = preg_replace("/{}/", $arg["value"], $format["value"], 1);
                } else if($arg["type"] == "word") {
                    $format["value"] = preg_replace("/{}/", $eva->resolve($arg["name"], $scope, $eva->app), $format["value"], 1);
                }
            }

            $scope->write($format["value"], "post");
        };
    }
    
    public function init()
    {
        $this->result = "";
        $this->preresult = "";
        $this->postresult = "";
    }

    public function evaluate($ast, Scope $scope)
    {
        if($ast["type"] == "statements") {
            $statements = $ast["statements"];

            if(!$scope->getParent() && count($statements) == 1) {
                if($statements[0]["type"] == "word") {
                    $value = [
                        "type" => "value",
                        "value" => "{}"
                    ];

                    $this->functions["print"]([$value, $statements[0]], $scope);
                }
            }

            foreach($statements as $statement) {
                $this->evaluate($statement, $scope);
            }
        } else if($ast["type"] == "construct") {
            if($ast["operator"]["name"] == "foreach") {
                $iterator = $this->resolve($ast["iterator"]["name"], $scope);

                $iterScope = Scope::inherit($scope);
                $iterScope->setGlue($ast["join"]["value"]);

                $scope->setDefined($ast["into"]["name"], "");
                
                foreach($iterator as $item) {
                    $statements = $ast["statements"]["statements"];

                    $iterScope->setDefined($ast["as"]["name"], $item);

                    //$scope->setDefined($ast["into"]["name"], "");
                    $iterScope->setDefined("into_key", $ast["into"]["name"]);

                    foreach($statements as $statement) {
                        $this->evaluate($statement, $iterScope);
                    }
                }

                $iterScope->finish(true);
            }
        } else if($ast["type"] == "apply")  {

            if($ast["operator"]["type"] == "word" && array_key_exists($ast["operator"]["name"], $this->functions)) {

                return $this->functions[$ast["operator"]["name"]]($ast["args"], $scope);
            }
        } else if($ast["type"] == "value") {
            return $ast["value"];
        } else if($ast["type"] == "word") {
            return $this->resolve($ast["name"], $scope);
        } else if($ast["type"] == "assignment") {
            if($ast["value"]["type"] == "value") {
                $value = $ast["value"]["value"];
            } else if($ast["value"]["type"] == "word") {
                $value = $this->resolve($ast["value"]["name"], $scope);
            }

            $scope->setDefined($ast["variable"]["name"], $value);
            //return $this->resolve($ast["name"], $scope);
        }

        return $scope->finish();
    }

    protected function resolve($name, $scope)
    {
        if(preg_match("/^(\w+)((?:\.[\w@]+)+)/", $name, $matches)) {
            return $scope->getDefined($matches[1])->resolve(trim($matches[2], '.'), $this->app);
        } else {
            return $scope->getDefined($name);
        }
    }
}