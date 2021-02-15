<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptCommand extends Command
{
    protected $signature = 'erupt {--app} {--template} {--result}';

    protected $description = 'Create your Laravel app';

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }
    
    public function handle()
    {
        if($this->option("app")) {
            print_r($this->app);
        }

        $file_specs = $this->app->get_file_specs();

        $op_template = $this->option("template");
        $op_result = $this->option("result");

        foreach($file_specs as $spec) {
            $this->call("erupt:make", $spec->get_args_and_options($op_template, $op_result));
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