<?php

namespace Erupt\Traits;

trait HasParams
{
    protected array $args = [];

    public function getArg(string $name)
    {
        foreach($this->args as $arg) {
            if($arg['param'] == $name) {
                return $arg;
            }
        }

        throw new \Exception($name);
    }

    protected function evalAndTakeArgs(string $args, $scope = null): self
    {
        return $this->takeArgs($this->evalArgs($args, $scope));
    }

    protected function evalArgs(string $args, $scope = null): string
    {
        if(empty($scope)) {
            return $args;
        }

        return preg_replace_callback(
            "/(?:{(\w+)})(.*)/",
            function ($matches) use ($scope) {
                return $scope->getArg($matches[1]).$matches[2];
            },
            $args
        );
    }

    protected function takeArgs(string $args): self
    {
        $params = $this->parseParams(array_map('trim', explode(',', $this->params)));

        $parsedArgs = $this->parseArgs($args);

        foreach($params as $index => $param) {
            try {
                $this->args[$index] = $this->takeArg($parsedArgs, $index, $param);
            } catch (\Exception $e) {
                echo 'Too few arguments: ', $e->getMessage(), "\n";
            }
        }

        return $this;
    }

    protected function parseParams(array $params): array
    {
        return array_map(array($this, 'parseParam'), $params);
    }

    protected function parseParam(string $param): array
    {
        $result = [];

        $result['name'] = trim($param, '?');
        $result['optional'] = str_ends_with($param, '?') ? true : false;

        return $result;
    }
    
    protected function parseArgs(string $args): array
    {
        return array_map('trim', explode(',', $args));
    }

    protected function takeArg(array $args, int $index, array $param): string
    {
        if(array_key_exists($index, $args)) {
            return [
                'param' => $param[$index],
                'arg' => $args[$index],
            ];
        } else if($param['optional']) {
            return [
                'param' => $param[$index],
                'arg' => null,
            ];
        } else {
            throw new \Exception($key);
        }
    }
}