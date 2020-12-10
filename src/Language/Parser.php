<?php

namespace Erupt\Language;

class Parser
{
    public function parse($program)
    {
        return $this->parseStatements($program);
    }

    protected function parseStatements($program)
    {
        $statements = [ "type" => "statements", "statements" => [] ];

        while($program != "") {
            $result = $this->parseStatement($program);
            $statement = $result["statement"];
            $program = $result["rest"];

            $program = $this->skipSpace($program);

            $statements["statements"][] = $statement;
        }

        return $statements;
    }

    protected function parseStatement($program)
    {
        $result = $this->parseExpression($program);

        $expr = $result["expr"];
        $program = $result["rest"];

        if($expr["type"] == "value") {
            $r = [
                "statement" => $result["expr"],
                "rest" => $result["rest"],
            ];
            return $r;
        } else if($expr["type"] == "word") {
            if($expr["name"] == "foreach") {
                return $this->parseForeach($expr, $program);
            } else {
                $r = [
                    "statement" => $result["expr"],
                    "rest" => $result["rest"],
                ];
                return $r;
            }
        } else if($expr["type"] == "apply") {
            $r = [
                "statement" => $result["expr"],
                "rest" => $result["rest"],
            ];
            return $r;
        } else if($expr["type"] == "assignment") {
            return [
                "statement" => $result["expr"],
                "rest" => $result["rest"],
            ];
        }
    }

    protected function parseBlock($program)
    {
        $program = $this->skipSpace($program);

        $statements = [ "type" => "statements", "statements" => [] ];

        if(preg_match("/{/", $program, $matches)) {
            $program = substr($program, strlen($matches[0]));
        }

        while(substr($program, 0, 1) != '}') {
            $result = $this->parseStatement($program);
            $program = $result["rest"];
            $sttm = $result["statement"];
            
            $statements["statements"][] = $sttm;

            $program = $this->skipSpace($program);
        }

        return [ "statements" => $statements, "rest" => substr($program, 1) ];
    }

    protected function parseForeach($expr, $program)
    {
        $sttm = [ "type" => "construct", "operator" => $expr ];

        $result = $this->parseExpression($program);
        $sttm["iterator"] = $result["expr"];
        $program = $result["rest"];

        $result = $this->parseAs($program);
        $sttm["as"] = $result["expr"];
        $program = $result["rest"];

        $result = $this->parseJoin($program);
        $sttm["join"] = $result["expr"];
        $program = $result["rest"];

        $result = $this->parseInto($program);
        $sttm["into"] = $result["expr"];
        $program = $result["rest"];

        $result = $this->parseBlock($program);
        $sttm["statements"] = $result["statements"];
        $program = $result["rest"];

        return [ "statement" => $sttm, "rest" => $program ];
    }

    protected function parseAs($program)
    {
        $program = $this->skipSpace($program);

        if(preg_match("/^as/", $program, $matches)) {
            $program = substr($program, strlen($matches[0]));

            $program = $this->skipSpace($program);

            $result = $this->parseIdentifier($program);
        }

        return $result;
    }

    protected function parseIdentifier($program)
    {
        $program = $this->skipSpace($program);

        if(preg_match("/^\w+/", $program, $matches)) {
            $expr = [ "type" => "word", "name" => $matches[0] ];
        } else {
            //  throw new SyntaxError
        }
        
        return [ "expr" => $expr, "rest" => substr($program, strlen($matches[0]))];
    }

    protected function parseJoin($program)
    {
        $program = $this->skipSpace($program);

        $expr = [ "type" => "value", "value" => "\n" ];
        $result = [ "expr" => $expr, "rest" => $program ];

        if(preg_match("/^join/", $program, $matches)) {
            $program = substr($program, strlen($matches[0]));

            $program = $this->skipSpace($program);

            $result = $this->parseExpression($program);
        }

        return $result;
    }


    protected function parseInto($program)
    {
        $program = $this->skipSpace($program);

        $expr = [ "type" => "word", "name" => "into" ];
        $result = [ "expr" => $expr, "rest" => $program ];

        if(preg_match("/^into/", $program, $matches)) {
            $program = substr($program, strlen($matches[0]));

            $program = $this->skipSpace($program);

            $result = $this->parseIdentifier($program);
        }

        return $result;
    }

    //  https://eloquentjavascript.net/12_language.html
    protected function parseExpression($program)
    {
        $program = $this->skipSpace($program);
        
        if(preg_match("/^\"([^\"]*)\"/", $program, $matches)) {
            $expr = [ "type" => "value", "value" => $matches[1] ];
        } else if(preg_match("/^\d+/", $program, $matches)) {
            $expr = [ "type" => "value", "value" => $matches[0] ];
        } else if(preg_match("/^[^\s(){},]+/", $program, $matches)) {
            $expr = [ "type" => "word", "name" => $matches[0] ];
        } else {
            //  throw new SyntaxError
        }

        return $this->parseApplyOrAssignment($expr, substr($program, strlen($matches[0])));
        //return $this->parseApply($expr, substr($program, strlen($matches[0])));
    }
    
    protected function skipSpace($program)
    {
        return ltrim($program);
    }

    protected function parseApplyOrAssignment($expr, $program)
    {
        $program = $this->skipSpace($program);

        if(substr($program, 0, 1) == '=') {
            return $this->parseAssignment($expr, $program);
        }

        return $this->parseApply($expr, $program);
    }

    protected function parseAssignment($expr, $program)
    {
        $program = $this->skipSpace($program);
        if(substr($program, 0, 1) != '=') {
            return [ "expr" => $expr, "rest" => $program ];
        }

        $program = $this->skipSpace(substr($program, 1));
        $expr = [ "type" => "assignment", "variable" => $expr, "value" => null ];

        $value = $this->parseExpression($program);
        $expr["value"] = $value["expr"];
        $program = $this->skipSpace($value["rest"]);

        return [ "expr" => $expr, "rest" => $program ];
    }
    
    //  https://eloquentjavascript.net/12_language.html
    protected function parseApply($expr, $program)
    {
        $program = $this->skipSpace($program);
        if(substr($program, 0, 1) != '(') {
            return [ "expr" => $expr, "rest" => $program ];
        }

        $program = $this->skipSpace(substr($program, 1));
        $expr = [ "type" => "apply", "operator" => $expr, "args" => [] ];
        while(substr($program, 0, 1) != ')') {
            $arg = $this->parseExpression($program);
            $expr["args"][] = $arg["expr"];
            $program = $this->skipSpace($arg["rest"]);
            if(substr($program, 0, 1) == ',') {
                $program = $this->skipSpace(substr($program, 1));
            } else if(substr($program, 0, 1) != ')') {
                //
            }
        }

        return $this->parseApply($expr, substr($program, 1));
    }
}