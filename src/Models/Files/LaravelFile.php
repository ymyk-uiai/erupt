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

    protected $fullUseAs;

    protected $instance;

    protected $path;

    public function __construct($props)
    {
        $this->type = $props["type"];

        $this->variant = array_key_exists("variant", $props) ? trim($props["variant"], ',') : '';

        $this->className = $props["className"];

        $this->namespace = $props["namespace"];

        $this->className = $props["className"];

        $this->namespace = $props["namespace"];

        $this->fullClassName = $props["fullClassName"];

        $this->useAs = $props["useAs"];

        $this->fullUseAs = $props["fullUseAs"];

        $this->instance = $props["instance"];

        $this->instances = $props["instance"].'s';

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
            return $this->{$name};
        }
    }
}