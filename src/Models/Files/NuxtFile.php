<?php

namespace Erupt\Models\Files;

use Erupt\Abstracts\Models\Files\File as AbstractFile;

class NuxtFile extends AbstractFile
{
    protected $type;

    protected $className;

    protected $namespace;

    protected $fullClassName;

    protected $useAs;

    protected $fullUseAs;

    protected $instance;

    protected $path;

    public function __construct($props)
    {
        $this->type = $props["type"];

        $this->variant = trim($props["variant"], ',');

        $this->variant = trim($variant, ',');

        $this->className = $props["className"];

        $this->namespace = $props["namespace"];

        $this->className = $props["className"];

        $this->namespace = $props["namespace"];

        $this->fullClassName = $props["fullClassName"];

        $this->useAs = $props["useAs"];

        $this->fullUseAs = $props["fullUseAs"];

        $this->instance = $props["instance"];

        $this->path = $props["path"];
    }

    public function try($keys)
    {
        $type = $keys[0];

        return $type == $this->type || $type == "{$this->type}@{$this->variant}" ? true : false;
    }

    public function get($keys)
    {
        $type = $keys[0];

        $name = $keys[1];

        if($type == $this->type || "{$this->type}@{$this->variant}") {
            print_r("$type:{$this->type}@{$this->variant}\n");
            return $this->{$name};
        }
    }
}