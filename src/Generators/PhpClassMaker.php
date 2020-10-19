<?php

namespace Erupt\Generators;

use Illuminate\Filesystem\Filesystem;

class PhpClassMaker
{
    protected $namespace;

    protected $name;

    protected $extends;

    protected $imports;

    public function __construct($json, $app)
    {
        $this->namespace = $this->getJsonProp("namespace", $json);

        $this->name = $this->getJsonProp("name", $json);

        $this->extends = $this->getJsonProp("extends", $json);

        $this->imports = $this->getJsonProp("imports", $json);

        $this->files = new Filesystem;

        $this->app = $app;
    }

    protected function getJsonProp($key, $json)
    {
        if(array_key_exists($key, $json)) {
            return $json[$key];
        } else {
            return "";
        }
    }

    public function makeFile()
    {
        $file = "<?php\n\n";

        $file .= $this->format("namespace {};\n\n", [$this->namespace]);

        $file .= $this->format("class {}", [$this->name]);

        if($this->extends) {
            $file .= $this->format(" extends {}", [$this->extends]);
        }

        $file .= "\n{\n";
        
        foreach($this->imports as $import) {

            $args = $import["args"] ?? null;
            $template = $import["template"];

            $template = $this->getTemplate($template, $args);

            $file .= $template."\n\n";
        }

        $file .= "}";

        return $file;
    }

    protected function format($format, $args)
    {
        foreach($args as $arg) {
            $format = preg_replace("/{}/", $arg, $format, 1);
        }

        return $format;
    }

    protected function getTemplate($name, $args)
    {
        $args = $this->parseArgs($args);

        $template = $this->files->get($this->app->getComponent($name));

        $template = str_replace(array_keys($args), array_values($args), $template);

        return $template;
    }

    protected function parseArgs($args)
    {
        $result = [];

        if(!$args) {
            return $result;
        }

        $args = explode(',', $args);

        foreach($args as $arg) {
            $keyValue = explode('=', $arg);

            $result["@{$keyValue[0]}@"] = $keyValue[1];
        }

        return $result;
    }
}