<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Foundations\BaseItem;
use Erupt\Models\Models\Items\{User, Post, Folder, Comment};

abstract class BaseRelationship extends BaseItem
{
    protected function addDefaultRelationalAttributes(string $attrs, string $modelType, string $target): string
    {
        $defaultAttributes = match ($modelType) {
            "user" => User::getDefaultRelationalAttributes($target),
            "post" => Post::getDefaultRelationalAttributes($target),
            "folder" => Folder::getDefaultRelationalAttributes($target),
            "comment" => Comment::getDefaultRelationalAttributes($target),
            default => throw new Exception("unknown model type"),
        };

        //  print_r("modelType:\t$modelType\ttarget:\t$target\tattributes\t$defaultAttributes\n");
        //  print_r(implode('|', array_filter([$attrs, $defaultAttributes]))."\n");

        return implode('|', array_filter([$attrs, $defaultAttributes]));
    }
}