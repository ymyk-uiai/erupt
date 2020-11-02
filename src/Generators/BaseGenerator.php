<?php

namespace Erupt\Generators;

use Erupt\Models\Lists\Files\FileList;
use Erupt\Models\Models\Auth;
use Erupt\Models\Models\Content;
use Erupt\Models\Models\Binder;
use Erupt\Models\Models\Response;

class BaseGenerator
{
    public function getCommands($model): array
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
        return $this->filterCommands($this->getAuthCommandKeys());
    }

    public function getContentCommands()
    {
        return $this->filterCommands($this->getContentCommandKeys());
    }

    public function getBinderCommands()
    {
        return $this->filterCommands($this->getBinderCommandKeys());
    }

    public function getResponseCommands()
    {
        return $this->filterCommands($this->getResponseCommandKeys());
    }

    protected function filterCommands($keys)
    {
        $commands = $this->getAllCommands();

        return array_filter($commands, function ($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function makeType($name, $command)
    {
        return $command["command"];
    }

    public function makeVariant($name, $command)
    {
        return array_key_exists("variant", $command) ? ",{$command['variant']}" : '';
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

    public function makeFullUseAs($name, $command)
    {
        $className = $this->makeClassName($name, $command);
        $namespace = $this->makeNamespace($name, $command);

        $fullnamespace = trim($namespace, '\\') . '\\' . trim($className, '\\');

        $base = ucfirst(strtolower($name));

        if(array_key_exists("useAs", $command) && substr($command["useAs"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["useAs"]);
        }

        return "$fullnamespace as $base";
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

    protected function getProps($name, $command)
    {
        $result = [];

        $propNames = $this->getPropNames();

        foreach($propNames as $propName) {
            $result[$propName] = $this->getProp($propName, $name, $command);
        }

        return $result;
    }

    public function generate($name, $command)
    {
        $className = $this->getFileClass();

        $props = $this->getProps($name, $command);

        return new $className($props);
    }

    protected function getProp($key, $name, $command)
    {
        $key = "make".ucfirst($key);

        return $this->{$key}($name, $command);
    }

    public function getFiles($model): FileList
    {
        $fileList = new FileList;

        $commands = $this->getCommands($model);

        //print_r($commands);

        foreach($commands as $command) {
            $file = $this->generate($model->getName(), $command);
            $fileList->add($file);
            //  $file = File::build($name, $command);
        }

        return $fileList;
    }

    public function getTemplatePath($modelType, $classType)
    {
        $basePath = $this->getBasePath();

        return "$basePath/models/$modelType/$classType.txt";
    }

    public function getComponentDir()
    {
        $basePath = $this->getBasePath();

        $componentDirName = $this->getComponentDirName();

        return "$basePath/$componentDirName/";
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