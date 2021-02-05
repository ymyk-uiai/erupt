<?php

namespace Erupt\Console\Commands\Laravel;

use Erupt\Console\Commands\BaseCommand;
use Erupt\Generators\Generators\Items\LaravelGenerator as Generator;
use Illuminate\Filesystem\Filesystem;
use Erupt\Application;

abstract class LaravelCommand extends BaseCommand
{
    protected string $baseNamespace = "App";

    protected string $baseDirectory = "app";

    protected $generator;

    protected $extention = "php";

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files, $app);

        $this->generator = new Generator;
    }
}