<?php

namespace Erupt\Relationships\Relationships;

use Erupt\Traits\HasFlags;
use Erupt\Models\Models\Items\{User, Post, Folder, Comment};

abstract class BaseRelationship
{
    use HasFlags;

    protected function addDefaultRelationalAttributes(string $attrs, string $modelType, string $target): string
    {
        $defaultAttributes = match ($modelType) {
            "user" => User::getDefaultRelationalAttributes($target),
            "post" => Post::getDefaultRelationalAttributes($target),
            "folder" => Folder::getDefaultRelationalAttributes($target),
            "comment" => Comment::getDefaultRelationalAttributes($target),
            default => throw new Exception("unknown model type"),
        };

        return implode('|', [$attrs, $defaultAttributes]);
    }
}