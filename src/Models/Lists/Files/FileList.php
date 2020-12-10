<?php

namespace Erupt\Models\Lists\Files;

use Erupt\Abstracts\Foundations\BaseList;

class FileList extends BaseList
{
    public function add($file)
    {
        parent::add($file);
    }

    public function remove($file)
    {
        parent::add($file);
    }

    public function resolve($keys, $app)
    {
        if(gettype($keys) == "string") {
            $keys = explode('.', $keys);
        }

        foreach($this->list as $file) {
            if($file->try($keys)) {
                return $file->get($keys);
            }
        }
    }
}