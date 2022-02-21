<?php

namespace Erupt\Relationships\Items;

use Erupt\Proposals\Items\MorphOneToManyHas;
use Erupt\Proposals\Items\MorphOneToManyBelongsTo;
use Erupt\Interfaces\Migrator;

class MorphOneToMany extends Morph implements Migrator
{
    protected function getHasProposal(string $key)
    {
        return MorphOneToManyHas::build("has:$key");
    }

    protected function getBelongsToProposal(string $key)
    {
        return MorphOneToManyBelongsTo::build("belongsTo:$key");
    }

    public function getCommand(): string
    {
        return "morphOneToMany";
    }

    public function getStatements(): array
    {
        return [];
    }
}