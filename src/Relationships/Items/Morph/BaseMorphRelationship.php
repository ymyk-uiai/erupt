<?php

namespace Erupt\Relationships\Items\Morph;

use Erupt\Relationships\BaseRelationship;
use Erupt\Primitives\Lists\PrimitiveList;
use Erupt\Primitives\BasePrimitive;
use Erupt\Proposals\Lists\RelationalProposalList;
use Erupt\Proposals\BaseProposal;
use Erupt\Foundation\Initializer as Ini;

abstract class BaseMorphRelationship extends BaseRelationship
{
    public function getRelationalProposals(string $planName): array
    {
        $rels = $this->primitives->checkRelation($planName);

        return array_reduce($rels, function ($carry, $rel) {
            $carry[] = $this->getProposal($rel);
            return $carry;
        }, []);
    }

    protected function getString(string $relation): string
    {
        return $this->primitives->getString($relation);
    }
}