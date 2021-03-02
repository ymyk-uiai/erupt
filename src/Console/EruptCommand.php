<?php

namespace Erupt\Console;

use Illuminate\Console\Command;
use Erupt\Application;

class EruptCommand extends Command
{
    protected $signature = 'erupt {--app} {--template} {--result} {--reset}';

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

        if($this->option("reset")) {
            $this->call("migrate:reset");
            exec("git clean -fd");
            exec("git restore app database routes resources");
            return;
        }

        $file_specs = $this->app->get_file_specs();

        $op_template = $this->option("template");
        $op_result = $this->option("result");

        foreach($file_specs as $spec) {
            $this->call("erupt:make", $spec->get_args_and_options($op_template, $op_result));
        }

        $migration_specs = $this->app->get_migration_specs();

        foreach($migration_specs as $migration) {
            if($migration->get_model_type() == "auth") continue;
            $this->call("make:migration", [
                "name" => $migration->get_command(),
            ]);
        }

        $migration_path = base_path("database/migrations");

        if ($handle = opendir($migration_path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    foreach($migration_specs as $spec) {
                        if(strpos($file, $spec->get_command())) {
                            $file_contents = file_get_contents("$migration_path/$file");
                            $pattern = "/(Schema::create\([^{]*{)[^}]*(}\);)/";
                            $m_command = $spec->get_migration();
                            $replace = "$1{$m_command}$2";
                            $file_contents = preg_replace($pattern, $replace, $file_contents);
                            file_put_contents("$migration_path/$file", $file_contents);
                        }
                    }
                }
            }
            closedir($handle);
        }

        $database_seeder = file_get_contents("database/seeders/DatabaseSeeder.php");

        $pattern = "/(public\s+function\s+run\(\)\s*{)[^}]+(})/";
        $string = $this->app->implode_seeders();
        $replace = "$1\n\$this->call([{$string}]);\n$2";
        $database_seeder = preg_replace($pattern, $replace, $database_seeder);

        file_put_contents("database/seeders/DatabaseSeeder.php", $database_seeder);

        $route_file = file_get_contents("routes/web.php");

        $target = "return view('welcome');";
        $replace = '$posts = App\Models\Post::all(); return view(\'welcome\', [\'posts\' => $posts]);';
        $route_file = str_replace($target, $replace, $route_file);

        $target = "return view('dashboard');";
        $replace = '$posts = Auth::user()->posts; return view("dashboard", ["posts" => $posts]);';
        $route_file = str_replace($target, $replace, $route_file);

        $pattern = "/$/";
        $string = $this->app->implode_routes();
        $replace = "require __DIR__.'/auth.php';$string";
        $route_file .= $string;

        file_put_contents("routes/web.php", $route_file);

        $policy_file = file_get_contents("app/Providers/AuthServiceProvider.php");

        $pattern = "/(protected\s+\\\$policies\s+=\s+\[).*?(\];)/ms";
        $policies = $this->app->implode_policies();
        $replace = "$1\n{$policies}\n$2";

        $policy_file = preg_replace($pattern, $replace, $policy_file);

        file_put_contents("app/Providers/AuthServiceProvider.php", $policy_file);
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