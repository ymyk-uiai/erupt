<?php

namespace Erupt\Traits;

use Exception;

trait HasParams
{
    protected array $args = [];

    protected function takeArgs(string|array $args): void
    {
        $params = $this->parseParams(array_map('trim', explode(',', $this->params)));

        $parsedArgs = $this->parseArgs($args);

        foreach($params as $index => $param) {
            try {
                $this->args[$param['name']] = $this->takeArg($parsedArgs, is_string($args) ? $index : $param['name'], $param);
            } catch (Exception $e) {
                echo 'Too few arguments: ', $e->getMessage(), "\n";
            }
        }
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
    
    protected function parseArgs(string|array $args): array
    {
        return is_string($args) ? array_map('trim', explode(',', $args)) : $args;
    }

    protected function takeArg(array $args, int|string $key, array $param): string
    {
        if(array_key_exists($key, $args)) {
            return $args[$key];
        } else if($param['optional']) {
            return "";
        } else {
            throw new Exception($key);
        }
    }
}