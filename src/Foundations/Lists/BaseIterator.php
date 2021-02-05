<?php

namespace Erupt\Foundations\Lists;

use Iterator;

/**
 * https://www.php.net/manual/en/language.oop5.iterations.php
 */
class BaseIterator implements Iterator
{
    private array $iterable = [];

    public function __construct($arr)
    {
        if (is_array($arr)) {
            $this->iterable = $arr;
        }
    }

    public function rewind()
    {
        reset($this->iterable);
    }
  
    public function current()
    {
        return current($this->iterable);
    }
  
    public function key() 
    {
        return key($this->iterable);
    }
  
    public function next() 
    {
        return next($this->iterable);
    }
  
    public function valid()
    {
        $key = key($this->iterable);
        return ($key !== NULL && $key !== FALSE);
    }
}