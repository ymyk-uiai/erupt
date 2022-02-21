<?php

namespace Erupt\Language;

use Erupt\Language\Parser;
use Erupt\Language\Evaluator;
use Erupt\Models\BaseModel as Model;
use Erupt\Files\BaseFile as File;

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

    public function exec(string $template, Model $model, File $file): string
    {
        $result = "";

        $pattern = "/<!erupt(.*)!>/sUm";
        $offset = 0;
        $prevOffset = 0;

        $scope = Scope::init([
            "self" => $model,
            "auth" => $this->app->getModels()->get("user"),
            "app" => $this->app,
            "shortName" => $file->getShortName(),
            "namespace" => $file->getNamespace(),
        ]);

        while(preg_match($pattern, $template, $matches, PREG_OFFSET_CAPTURE, $offset)) {

            $result .= substr($template, $offset, $matches[0][1] - $offset);

            $ast = $this->parser->parse($matches[1][0]);

            $result .= $this->evaluator->evaluate($ast, $scope);

            $scope->emptyStd();

            $offset = $matches[0][1] + strlen($matches[0][0]);
        }

        $result .= substr($template, $offset);

        $result = $this->removeDuplicatedUses($result);

        return $result;
    }

    protected function removeDuplicatedUses($result)
    {
        $pattern = "/^use\s+[a-zA-Z\\\\]+(\s+as\s+[a-zA-Z\\\\]+)?;/m";

        $lines = array_map("addslashes", explode(PHP_EOL, $result));

        $namespaces = array_map("trim", preg_grep($pattern, $lines));

        $namespaces = array_map("trim", array_unique($namespaces));

        sort($namespaces);

        $result = preg_replace($pattern, "", $result);

        $str_namespaces = implode("\n", $namespaces);

        $result = preg_replace("/\nclass/", "$str_namespaces\n\nclass", $result);

        return $result;
    }
}