<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;
use Erupt\Interfaces\MigrationFile;
use Erupt\Interfaces\PhpClassFile;

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
        /*
        foreach($this->app->getFiles() as $file) {
            if($file instanceof MigrationFile) {
                $this->call("make:migration", [
                    "name" => $file->access('tableName')."",
                ]);
            }
        }
        */

        //  /*
        foreach($this->app->getFiles() as $file) {
            if($file instanceof PhpClassFile) {
                $this->call("erupt:make", [
                    "file" => $file,
                ]);
            }
        }
        //  */
    }
}