<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptActivateCommand extends Command
{
    protected $signature = "erupt";

    protected $description = 'Create a Laravel app';

    protected Application $app;

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    public function handle()
    {
        foreach($this->app->getFiles() as $file) {
            $this->call("erupt:make", [
                "file" => $file,
            ]);
        }

        /*
        foreach($this->app->getMigrations() as $migration) {
            $this->call("make:migration", [
                "name" => $migration->getCommand(),
            ]);
        }
        */

        $this->writeMigrations();

        $this->app->dispatchEvents();

        $this->writeSeeders();

        $this->writeRoutes();

        $this->writeProvider();
    }

    protected function writeMigrations(): void
    {
        $dir = base_path("database/migrations");

        if($handle = opendir($dir)) {
            while(false != ($file = readdir($handle))) {
                if($file == "." || $file == "..") {
                    continue;
                }
                if($cor = $this->app->getMigration($file)) {
                    file_put_contents("$dir/$file", $cor->getContent());
                }
            }
            closedir($handle);
        }
    }

    protected function write(string $file, string $template, string $value): void
    {
        $templateFile = file_get_contents($file);

        file_put_contents($file, str_replace("//REPLACE//", $value, $templateFile));
    }

    protected function writeSeeders(): void
    {
        $file = "database/seeders/DatabaseSeeder.php";
        $template = "";
        $value = $this->app->getSeeders()->get();

        $this->write($file, $template, $value);
    }

    protected function writeRoutes(): void
    {
        $file = "routes/web.php";
        $template = "";
        $value = $this->app->getRoutes()->get();

        $this->write($file, $template, $value);
    }

    protected function writeProvider(): void
    {
        $file = "app/Providers/AuthServiceProvider.php";
        $template = "";
        $value = $this->app->getAuthProviders()->get();

        $this->write($file, $template, $value);
    }
}