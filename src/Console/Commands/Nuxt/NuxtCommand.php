<?php

namespace Erupt\Console\Commands\Nuxt;

use Erupt\Console\Commands\BaseCommand;
use Erupt\Generators\NuxtGenerator\NuxtGenerator as Generator;
use Illuminate\Filesystem\Filesystem;
use Erupt\Application;

abstract class NuxtCommand extends BaseCommand
{
    protected string $baseNamespace = "Client";

    protected string $baseDirectory = "client";

    protected $generator;

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files, $app);
        
        $this->generator = new Generator;
    }
}