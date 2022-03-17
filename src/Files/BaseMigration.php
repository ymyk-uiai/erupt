<?php

namespace Erupt\Files;

use Erupt\Application as A;
use Erupt\Plans\BasePlan as P;
use Erupt\Relationships\BaseRelationship as R;
use Erupt\Interfaces\MigrationFile;
use Erupt\Values\BaseValue;

abstract class BaseMigration extends BasePhpClass implements MigrationFile
{
    protected function makeValueList(P|R $fileMaker): array
    {
        $tableName = $this->makeTableName($fileMaker);
    
        return array_merge(parent::makeValueList($fileMaker), [
            "tableName:$tableName",
        ]);
    }

    abstract protected function makeTableName($fileMaker): string;
}