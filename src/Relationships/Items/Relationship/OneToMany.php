<?php

namespace Erupt\Relationships\Items\Relationship;

use Erupt\Proposals\Lists\RelationalProposalList;

class OneToMany extends BaseRelationshipRelationship
{
    protected function getProposal(string $relation): string
    {
        return match($relation) {
            'has' => "Relationship\\OneToMany\\Has::hasMany:".$this->getString('belongsTo'),
            'belongsTo' => "Relationship\\OneToMany\\BelongsTo::belongsTo:".$this->getString('has'),
        };
    }
}