<?php

namespace Erupt\Language;

use Erupt\Interfaces\Resolver;

class Scope
{
    protected string $iterator;

    protected string $iterKey;

    protected $iterValue;

    protected string $glue = "\n";

    protected array $defined = [];

    protected array $stdout = [];

    protected ?Self $parent = null;

    public static function make()
    {
        //
    }

    public static function init(array $defined)
    {
        $product = new Self;

        $product->defined = $defined;

        return $product;
    }

    public static function inherit(Self $parent)
    {
        $product = new Self;

        $product->parent = $parent;

        return $product;
    }

    public function getIter(bool $key)
    {
        return $key ? $this->iterKey : $this->iterValue;
    }

    public function setIter($key, $value)
    {
        $this->iterKey =  $key;

        $this->iterValue = $value;
    }

    public function getGlue()
    {
        return $this->glue;
    }

    public function setGlue(string $glue)
    {
        $this->glue = $glue;
    }

    public function getDefined($key)
    {
        if(array_key_exists($key, $this->defined)) {
            if($this->defined[$key] instanceof Resolver) {
                return $this->defined[$key]->evaluate();
            } else {
                return $this->defined[$key];
            }
        } else if($this->parent) {
            return $this->parent->getDefined($key);
        } else {
            return false;
        }
    }

    public function setDefined($key, $value)
    {
        $this->defined[$key] = $value;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function write(string $data, string $place = null)
    {
        if($place == "pre") {
            $this->initStdout("pre", "");

            $this->stdout["pre"] = $data;
        } else if ($place == "post") {
            $this->initStdout("post", "");

            $this->stdout["post"] = $data;
        } else {
            $this->initStdout("result", []);

            $this->stdout["result"][] = $data;
        }
    }

    public function emptyStd()
    {
        $this->stdout["pre"] = "";
        $this->stdout["result"] = [];
        $this->stdout["post"] = "";
    }

    protected function initStdout(string $key, $init)
    {
        if(!array_key_exists($key, $this->stdout)) {
            $this->stdout[$key] = $init;
        }
    }

    public function finish(bool $flag = false)
    {
        $data = $this->getStdout("pre");
        $data .= implode($this->glue, $this->getStdout("result", true));
        $data .= $this->getStdout("post");

        if($this->parent && $flag) {
            if(!array_key_exists("into_key", $this->defined)) {
                //
                return false;
            }
            $into_key = $this->defined["into_key"];
            $p = $this->getParent();
            $p->setDefined($into_key, $data);
        } else {
            return $data;
        }
    }

    public function getStdout(string $key, bool $returnArray = false)
    {
        if(array_key_exists($key, $this->stdout)) {
            return $this->stdout[$key];
        } else {
            return $returnArray ? [] : "";
        }
    }
}