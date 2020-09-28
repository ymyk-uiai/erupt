<?php

namespace Erupt\Models\Files;

use Erupt\Abstracts\Models\Files\File as AbstractFile;

class LaravelFile extends AbstractFile
{
    protected $type;

    protected $className;

    protected $namespace;

    protected $fullClassName;

    protected $useAs;

    protected $instance;

    protected $path;

    public function __construct($type, $variant, $className, $namespace, $fullClassName, $useAs, $instance, $path)
    {
        $this->type = $type;

        $this->variant = $variant;

        $this->className = $className;

        $this->namespace = $namespace;

        $this->fullClassName = $fullClassName;

        $this->useAs = $useAs;

        $this->instance = $instance;

        $this->path = $path;
    }

    public function get($keys)
    {
        $type = $keys[0];

        $name = $keys[1];

        if($type == $this->type) {
            return $this->{$name};
        }
    }
}