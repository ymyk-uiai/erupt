<?php

namespace Erupt\Relationships\Items;

use Erupt\Proposals\Items\NormalOneToManyHas;
use Erupt\Proposals\Items\NormalOneToManyBelongsTo;

class NormalOneToMany extends Normal
{
    //  Erupt\Proposals\Items\Normal\OneToMany\Has;
    //  Erupt\Proposals\Items\Normal\OneToMany\BelongsTo;

    //  return new Has;
    //  return new BelongsTo;

    protected function getHasProposal(string $key)
    {
        return NormalOneToManyHas::build("has:$key");
    }

    protected function getBelongsToProposal(string $key)
    {
        return NormalOneToManyBelongsTo::build("belongsTo:$key");
    }
}