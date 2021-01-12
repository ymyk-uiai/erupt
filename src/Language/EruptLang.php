<?php

namespace Erupt\Language;

use Erupt\Language\Parser;
use Erupt\Language\Evaluator;
use Ds\Set;
use PhpParser\PrettyPrinter;
use PhpParser\Error;
use PhpParser\ParserFactory;

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
            "className" => $this->app->get_files()->resolve($self, "$type.className", $this->app),
            "namespace" => $this->app->get_files()->resolve($self, "$type.namespace", $this->app),
        ]);

        while(preg_match($pattern, $template, $matches, PREG_OFFSET_CAPTURE, $offset)) {

            $result .= substr($template, $offset, $matches[0][1] - $offset);

            $ast = $this->parser->parse($matches[1][0]);

            $result .= $this->evaluator->evaluate($ast, $scope);
            
            //$this->evaluator->init();

            $scope->emptyStd();

            $offset = $matches[0][1] + strlen($matches[0][0]);
        }

        $result .= substr($template, $offset);

        $result = $this->removeDuplicatedUses($result);

        /*
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($result);
            $prettyPrinter = new PrettyPrinter\Standard;
            $result = $prettyPrinter->prettyPrintFile($ast);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }
        */

        print_r("\033[31m$modelName $type\033[0m\n");
        print_r("\033[33m".trim($template)."\033[0m\n");
        print_r("\033[32m".trim($result)."\033[0m\n");

        //$ast = $this->parser->parse($template);

        //return $this->evaluator->evaluate($ast);

        return $result;
    }

    protected function removeDuplicatedUses($result)
    {
        $pattern = "/^use\s+[a-zA-Z\\\\]+(\s+as\s+[a-zA-Z\\\\]+)?;/m";

        $lines = array_map("trim", array_map("addslashes", explode(PHP_EOL, $result)));

        $namespaces = preg_grep($pattern, $lines);

        $namespaces = array_unique($namespaces);

        sort($namespaces);

        $result = preg_replace($pattern, "", $result);

        $str_namespaces = implode("\n", $namespaces);

        $result = preg_replace("/\nclass/", "$str_namespaces\n\nclass", $result);

        return $result;
    }
}