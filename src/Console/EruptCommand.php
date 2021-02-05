<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptCommand extends Command
{
    protected $signature = 'erupt';

    protected $description = 'Create your Laravel app';

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }
    
    public function handle()
    {
        print_r($this->app);

        $file_specs = $this->app->get_file_specs();

        foreach($file_specs as $spec) {
            $this->call("erupt:make", $spec->get_args_and_options());
        }
    }

    protected function makeCommand($seed)
    {
        print_r($seed);
        return "erupt:{$seed['command']}";
    }

    protected function makeArgsAndOptions($seed)
    {
        return [
            "name" => $seed["name"],
            "--model" => lcfirst($seed["modelName"]),
        ];
    }
}