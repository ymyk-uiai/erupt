<?php

namespace Erupt\Language;

use Erupt\Language\Parser;
use Erupt\Language\Evaluator;
use Erupt\Models\BaseModel as Model;
use Erupt\Files\BaseFile;

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

    public function exec(BaseFile $file, Scope $scope): string
    {
        $result = "";

        $pattern = "/<!erupt(.*)!>/sUm";
        $offset = 0;
        $prevOffset = 0;

        $template = $file->getTemplate();

        while(preg_match($pattern, $template, $matches, PREG_OFFSET_CAPTURE, $offset)) {

            $result .= substr($template, $offset, $matches[0][1] - $offset);

            $ast = $this->parser->parse($matches[1][0]);

            $result .= $this->evaluator->evaluate($ast, $scope);

            $scope->emptyStd();

            $offset = $matches[0][1] + strlen($matches[0][0]);
        }

        $result .= substr($template, $offset);

        return $result;
    }
}