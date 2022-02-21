<?php

namespace Erupt\Files\Lists;

use Erupt\Files\BaseFileList;
use Erupt\Application;
use Erupt\Plans\Lists\PlanList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Files\LaravelClass\Model;
use Erupt\Files\LaravelClass\Controller;

class FileList extends BaseFileList
{
    public static $files = [
        Model::class,
        Controller::class,
    ];

    public static function build(Application $app, PlanList $plans, RelationshipList $relationships): self
    {
        $files = parent::build($app, $plans, $relationships);

        self::ite($plans, $files, $app);
        self::ite($relationships, $files, $app);

        return $files;
    }

    protected static function ite($iterable, $list, $app)
    {
        foreach(self::$files as $file) {
            foreach($iterable as $i) {
                if($file::isTarget($i)) {
                    $list->add($file::make($i, $app));
                }
            }
        }
    }
}