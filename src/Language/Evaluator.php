<?php

namespace Erupt\Language;

class Evaluator
{
    protected $result = "";

    protected $constructs = [];

    protected $functions = [];

    protected $reserved = [];

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

        $eva = $this;

        $this->functions["print"] = function ($args, $scope) use ($eva) {
            print_r("functions:print\n");
            $format = array_shift($args);

            foreach($args as $arg) {
                if($arg["type"] == "value") {
                    $format["value"] = preg_replace("/{}/", $arg["value"], $format["value"], 1);
                } else if ($arg["type"] == "word") {
                    $format["value"] = preg_replace("/{}/", $eva->resolve($arg["name"], $scope, $eva->app), $format["value"], 1);
                }
            }

            print_r("format\n");
            print_r($format["value"]);

            $eva->result .= $format["value"];
        };
    }
    
    public function init()
    {
        $this->result = "";
    }

    public function evaluate($ast, $scope)
    {
        print_r("Evaluator->evaluate\n");
        //print_r($ast);

        if($ast["type"] == "statements") {
            $statements = $ast["statements"];
            foreach($statements as $statement) {
                $this->evaluate($statement, $scope);
            }
        } else if($ast["type"] == "construct") {
            if($ast["operator"]["name"] == "foreach") {
                $iterator = $this->resolve($ast["iterator"]["name"], $scope);
                print_r("iterator\n");
                print_r($ast["iterator"]["name"]."\n");
                print_r($iterator);
                foreach($iterator as $item) {
                    $statements = $ast["statements"]["statements"];
                    $iterScope = $scope;
                    $iterScope[$ast["as"]["name"]] = $item;
                    $iterScope["join"] = $ast["join"]["value"];
                    foreach($statements as $statement) {
                        $this->evaluate($statement, $iterScope);
                        $this->result .= $iterScope["join"];
                    }
                }
            }
        } else if($ast["type"] == "apply")  {
            print_r("apply\n");
            
            if($ast["operator"]["type"] == "word" && array_key_exists($ast["operator"]["name"], $this->functions)) {
                print_r("the function exists\n");

                return $this->functions[$ast["operator"]["name"]]($ast["args"], $scope);
            }
        } else if($ast["type"] == "value") {
            return $ast["value"];
        } else if($ast["type"] == "word") {
            return $this->resolve($ast["name"], $scope);
        }

        return $this->result;
    }

    protected function resolve($name, $scope)
    {
        print_r("Evaluator->resolve\n");
        print_r("$name\n");

        if(preg_match("/^(\w+)((?:\.\w+)+)/", $name, $matches)) {
            return $scope[$matches[1]]->resolve(trim($matches[2], '.'), $this->app);
        } else {
            return $scope[$name];
        }
    }
}