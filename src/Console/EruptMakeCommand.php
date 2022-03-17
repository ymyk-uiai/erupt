<?php

namespace Erupt\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Erupt\Application;
use Erupt\Language\EruptLang;

class EruptMakeCommand extends GeneratorCommand
{
    protected $signature = 'erupt:make {file*}';

    protected $description = 'make a laravel component';

    public function __construct(Filesystem $files, Application $app)
    {
        parent::__construct($files);

        $this->app = $app;
    }

    public function handle()
    {
        $file = $this->argument("file");

        $this->makeDirectory($file->access('path')."");

        $fileName = $file->access('path') . '/' . $file->access('shortName');

        $this->files->put(base_path($fileName), $file->getContent());

        //$this->info("{$file['name']} created successfully.");
    }

    protected function registerEvents(array $events): void
    {
        foreach($events as $event) {
            $this->registerEvent($event);
        }
    }

    protected function registerEvent(string $event): void
    {
        $this->app->registerEvent($event);
    }

    protected function getStub() {}
}