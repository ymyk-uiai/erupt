<?php

namespace Erupt\Generators\Generators;

use Erupt\Foundations\Lists\BaseListItem;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Models\Models\Auth;
use Erupt\Models\Models\Content;
use Erupt\Models\Models\Binder;
use Erupt\Models\Models\Response;

class BaseGenerator extends BaseListItem
{
    public function getCommandSeeds($commandSeedKeys, $name)
    {
        $commandSeeds = $this->filterCommands($commandSeedKeys);

        return $this->updateCommandSeeds($commandSeeds, $name);
    }

    protected function updateCommandSeeds($commandSeeds, $name)
    {
        $result = [];

        foreach($commandSeeds as $seedName => $seedValue) {
            $inner = [];
            foreach($seedValue as $key => $value) {
                $updated = str_replace('@', $name, $value);
                $inner[$key] = $updated;
            }

            $inner["modelName"] = $name;
            $inner["name"] = $inner["name"] ?? $name;
            $result[] = $inner;
        }

        return $result;
    }

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
        $class_name = $this->makeClassName($name, $command);
        $namespace = $this->makeNamespace($name, $command);

        return trim($namespace, '\\') . '\\' . trim($class_name, '\\');
    }

    public function makeUseAs($name, $command)
    {
        $base = ucfirst(strtolower($name));

        if(array_key_exists("use_as", $command) && substr($command["use_as"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["use_as"]);
        }
        
        return $base;
    }

    public function makeFullUseAs($name, $command)
    {
        $class_name = $this->makeClassName($name, $command);
        $namespace = $this->makeNamespace($name, $command);

        $fullnamespace = trim($namespace, '\\') . '\\' . trim($class_name, '\\');

        $base = ucfirst(strtolower($name));

        if(array_key_exists("use_as", $command) && substr($command["use_as"], 0, 1) === '@') {
            $base = str_replace('@', $base, $command["use_as"]);
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
        $class_name = $this->getFileClass();

        $props = $this->getProps($name, $command);

        return new $class_name($props);
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

        foreach($commands as $command) {
            $file = $this->generate($model->getName(), $command);
            $fileList->add($file);
            //  $file = File::build($name, $command);
        }

        return $fileList;
    }

    public function get_file($model, $keys)
    {
        $files = $this->getFiles($model);

        foreach($files as $file) {
            if($file->try($keys)) {
                return $file->get($keys);
            }
        }
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