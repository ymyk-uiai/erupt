<?php

namespace Erupt\Generators\Generators;

use Erupt\Foundations\BaseItem;
use Erupt\Models\Lists\Files\FileList;
use Erupt\Models\Models\Auth;
use Erupt\Models\Models\Content;
use Erupt\Models\Models\Binder;
use Erupt\Models\Models\Response;

class BaseGenerator extends BaseItem
{
    public function get_file($model, $keys)
    {
        $files = $this->getFiles($model);

        foreach($files as $file) {
            if($file->try($keys)) {
                return $file->get($keys);
            }
        }
    }
}