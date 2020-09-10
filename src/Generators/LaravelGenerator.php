<?php

namespace Erupt\Generators;

use Erupt\Models\Files\LaravelFile;
use Erupt\Models\Models\Auth;
use Erupt\Models\Models\Content;
use Erupt\Models\Models\Binder;
use Erupt\Models\Models\Response;
use Erupt\Models\Lists\Files\FileList;

class LaravelGenerator
{
    protected function getNamespaces()
    {
        return [
            "model" => "",
            "policy" => "Policies",
            "request" => "Http\Requests",
            "resource" => "Http\Resources",
            "collection" => "Http\Resources",
            "controller" => "Http\Controllers",
        ];
    }

    public function getCommands($model)
    {
        if($model instanceof Auth) {
            return $this->getAuthCommands();
        } else if($model instanceof Content) {
            return $this->getContentCommands();
        } else if($model instanceof Binder) {
            return $this->getBinderCommands();
        } else if($model instanceof Response) {
            return $this->getResponseCommands();
        }
    }

    public function getAuthCommands()
    {
        $targets = [
            "model",
            "policy",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
        ];

        return $this->filterCommands($targets);
    }

    public function getContentCommands()
    {
        $targets = [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
        ];

        return $this->filterCommands($targets);
    }

    public function getBinderCommands()
    {
        $targets = [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
        ];

        return $this->filterCommands($targets);
    }

    public function getResponseCommands()
    {
        $targets = [
            "model",
            "policy",
            "request/store",
            "request/update",
            "resource",
            "resource/collection",
            "controller",
        ];

        return $this->filterCommands($targets);
    }

    protected function filterCommands($targets)
    {
        $commands = $this->getAllCommands();

        return array_filter($commands, function ($key) use ($targets) {
            return in_array($key, $targets);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getAllCommands()
    {
        return [
            "model" => [
                "command" => "model",
            ],
            "policy" => [
                "command" => "policy",
                "name" => "@Policy",
            ],
            "request/store" => [
                "command" => "request",
                "name" => "@StoreRequest",
                "variant" => "store",
            ],
            "request/update" => [
                "command" => "request",
                "name" => "@UpdateRequest",
                "variant" => "update",
            ],
            "resource" => [
                "command" => "resource",
                "useAs" => "@Resource",
            ],
            "resource/collection" => [
                "command" => "collection",
                "name" => "@Collection",
            ],
            "controller" => [
                "command" => "controller",
                "name" => "@Controller",
            ],
            "component/card" => [
                "command" => "component",
                "name" => "Card",
            ],
            "component/form" => [
                "command" => "component",
                "name" => "Form",
            ],
            "page/index" => [
                "command" => "page",
                "name" => "index",
            ],
            "page/create" => [
                "command" => "page",
                "name" => "create",
            ],
            "page/_id/index" => [
                "command" => "page",
                "name" => "_id/index",
            ],
            "page/_id/update" => [
                "command" => "page",
                "name" => "_id/update",
            ],
            "store/index" => [
                "command" => "store",
                "name" => "index",
            ],
            "store/show" => [
                "command" => "store",
                "name" => "show",
            ],
            "store/store" => [
                "command" => "store",
                "name" => "store",
            ],
            "store/update" => [
                "command" => "store",
                "name" => "update",
            ],
            "store/destroy" => [
                "command" => "store",
                "name" => "destroy",
            ],
        ];
    }

    public function generate($name, $command)
    {
        $type = $command["command"];

        $variant = array_key_exists("variant", $command) ? ",{$command['variant']}" : '';

        $className = $this->makeClassName($name, $command);

        $namespace = $this->makeNamespace($name, $command);

        $fullClassName = $this->makeFullClassName($name, $command);

        $useAs = $this->makeUseAs($name, $command);

        $instance = $this->makeInstance($name, $command);

        $path = $this->makePath($name, $command);

        return new LaravelFile($type, $variant, $className, $namespace, $fullClassName, $useAs, $instance, $path);
    }

    public function makeClassName($name, $command)
    {
        $base = ucfirst(strtolower($name));

        if(array_key_exists("name", $command) && substr($command["name"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["name"]);
        }
        
        return $base;
    }

    public function makeNamespace($name, $command)
    {
        $namespaces = $this->getNamespaces();

        return "App\\".$namespaces[$command["command"]];
    }

    public function makeFullClassName($name, $command)
    {
        $className = $this->makeClassName($name, $command);
        $namespace = $this->makeNamespace($name, $command);

        return trim($namespace, '\\') . '\\' . trim($className, '\\');
    }

    public function makeUseAs($name, $command)
    {
        $base = ucfirst(strtolower($name));

        if(array_key_exists("useAs", $command) && substr($command["useAs"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["useAs"]);
        }
        
        return $base;
    }

    public function makeInstance($name, $command)
    {
        $base = lcfirst(strtolower($name));

        if(array_key_exists("name", $command) && substr($command["name"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["name"]);
        }
        
        return $base;
    }

    public function makePath($name, $command)
    {
        $namespaces = $this->getNamespaces();

        return $namespaces[$command["command"]];
    }

    public function getFiles($model): FileList
    {
        $fileList = new FileList;

        $commands = $this->getCommands($model);

        foreach($commands as $command) {
            $file = $this->generate($model->getName(), $command);
            $fileList->add($file);
            //  $file = File::build($name, $command);
        }

        return $fileList;
    }

    public function getTemplatePath($modelType, $classType)
    {
        return __DIR__."/templates/{$modelType}.{$classType}.txt";
    }

    public function makeCommand($input)
    {
        return "erupt:{$input['command']}";
    }

    public function makeParams($input, $modelName)
    {
        $name = array_key_exists("name", $input) ? str_replace('@', ucfirst($modelName), $input["name"]) : ucfirst($modelName);

        return [
            "name" => $name,
            "--model" => lcfirst($modelName),
        ];
    }
}