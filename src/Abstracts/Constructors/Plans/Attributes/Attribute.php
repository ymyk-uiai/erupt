<?php

namespace Erupt\Abstracts\Constructors\Plans\Attributes;

abstract class Attribute
{
    public static function parseParams($signature, $args)
    {
        $params = explode(',', $signature);

        $groups = [];
        $first_optional_index = -1;

        foreach($params as $index => $param) {
            $param = trim($param);

            $groups[$index]["name"] = trim($param, '?');
            $groups[$index]["pattern"] = "(?<".trim($param, '?').">\w+)";
            $groups[$index]["parenthes"] = 0;
            $groups[$index]["optional"] = false;

            if(preg_match("/\?$/", $param)) {
                $groups[$index]["optional"] = true;
                if($first_optional_index === -1) {
                    $first_optional_index = $index;
                }
                $groups[$first_optional_index]["parenthes"] += 1;
            }
        }

        $pattern = "";

        foreach($groups as $index => $group) {
            $pattern .= str_repeat("(:?", $group["parenthes"]);
            
            if($index > 0) {
                $pattern .= "\s*,\s*";
            }
            $pattern .= $group["pattern"];

            if($group["optional"]) {
                $pattern .= ')?';
            }
        }

        $pattern = "/{$pattern}/";

        //print_r($pattern."\n");

        if(gettype($args) === "string") {
            $argsStr = $args;

            preg_match($pattern, $argsStr, $args);
        }

        foreach($groups as $group) {
            if($group["optional"] && !array_key_exists($group["name"], $args)) {
                $args[$group["name"]] = null;
            }
        }

        //print_r($args);

        return $args;
    }
}