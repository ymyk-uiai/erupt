<?php

namespace Erupt\Relationships\Items\Morph;

use Erupt\Proposals\Lists\RelationalProposalList;
use Erupt\Proposals\BaseProposal;

class OneToMany extends BaseMorphRelationship
{
    protected function getProposal(string $relation): string
    {
        return match($relation) {
            'has' => "Morph\\OneToMany\\Has::hasMany:".$this->getString('belongsTo'),
            'belongsTo' => "Morph\\OneToMany\\BelongsTo::belongsTo:".$this->getString('has'),
        };
    }
}