<?php

namespace Erupt\Language;

use Erupt\Language\Parser;
use Erupt\Language\Evaluator;

class EruptLang
{
    protected $parser;

    protected $evaluator;

    protected $app;

    public function __construct($app)
    {
        $this->parser = new Parser;

        $this->evaluator = new Evaluator($app);

        $this->app = $app;
    }

    public function exec($template, $modelName, $type)
    {
        $result = "";

        $pattern = "/<!erupt(.*)!>/sUm";
        $offset = 0;
        $prevOffset = 0;
        
        $self = $this->app->getModels()->get($modelName);
        $auth = $this->app->getModels()->getByType("auth");
        $scope = Scope::init([
            "self" => $self,
            "auth" => $auth,
            "className" => $self->getFiles()->resolve("$type.className", $this->app),
            "namespace" => $self->getFiles()->resolve("$type.namespace", $this->app),
        ]);

        while(preg_match($pattern, $template, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            //print_r($matches);

            $result .= substr($template, $offset, $matches[0][1] - $offset);
            //print_r(substr($template, $offset, $matches[0][1]));

            $ast = $this->parser->parse($matches[1][0]);

            $result .= $this->evaluator->evaluate($ast, $scope);
            
            //$this->evaluator->init();

            $scope->emptyStd();

            $offset = $matches[0][1] + strlen($matches[0][0]);
        }

        $result .= substr($template, $offset);

        print_r("\033[31m$modelName $type\033[0m\n");
        print_r($template);
        print_r("$result\n");

        //$ast = $this->parser->parse($template);

        //return $this->evaluator->evaluate($ast);

        return $result;
    }
}