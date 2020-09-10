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

        /*
        $this->type = $command["command"];

        $this->variant = array_key_exists("variant", $command) ? ",{$command['variant']}" : '';

        $this->className = $generator->makeClassName($name, $command);

        $this->namespace = $generator->makeNamespace($name, $command);

        $this->fullClassName = $generator->makeFullClassName($name, $command);

        $this->useAs = $generator->makeUseAs($name, $command);

        $this->instance = $generator->makeInstance($name, $command);

        $this->path = $generator->makePath($name, $command);
        */
    }
}