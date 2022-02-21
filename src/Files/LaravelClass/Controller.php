<?php

namespace Erupt\Files\LaravelClass;

use Erupt\Files\BaseFile;
use Erupt\Plans\Items\User;
use Erupt\Plans\Items\Post;
use Erupt\Plans\Items\Folder;
use Erupt\Plans\Items\Comment;

class Controller extends BaseFile
{
    public static $targets = [
        User::class,
        Post::class,
        Folder::class,
        Comment::class,
    ];

    protected string $name;

    public static function make($subject, $app): self
    {
        $file = parent::make($subject, $app);

        $file->setName($subject->getName());

        return $file;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return "controller";
    }

    public function getName(): string
    {
        return $this->getPath()."/".ucfirst($this->name)."Controller.php";
    }

    public function getPath(): string
    {
        return "app/Http/Controllers";
    }

    public function getShortName(): string
    {
        return ucfirst($this->name);
    }

    public function getNamespace(): string
    {
        return "Application\\Http\\Controllers\\".ucfirst($this->name);
    }

    protected function getTopComponent(): string
    {
        $path = $this->getBaseComponentPath();

        return file_get_contents($path."/controller.txt");
    }
}