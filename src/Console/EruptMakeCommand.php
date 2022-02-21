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

        $this->makeDirectory($file->getPath());

        $this->files->put(base_path($file->getName()), $this->build());

        //$this->info("{$file['name']} created successfully.");
    }

    protected function build(): string
    {
        $file = $this->argument("file");

        [$template, $data] = $file->getTemplateAndData();

        $this->registerEvents($data["events"]);

        $lang = new EruptLang($this->app);

        print_r("$template\n\n");

        return $lang->exec($template, $file->getCorrespondingModel(), $file);
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