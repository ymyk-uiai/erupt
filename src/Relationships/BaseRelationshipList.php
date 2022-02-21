<?php

namespace Erupt\Relationships;

use Erupt\Foundation\BaseList;
use Erupt\Relationships\Items\{NormalOneToMany, MorphOneToMany};
use Erupt\Proposals\Lists\ProposalList;
use Erupt\Plans\BasePlan as Plan;

abstract class BaseRelationshipList extends BaseList
{
    public static function build(array $relationships): static
    {
        $product = new static;
        foreach($relationships as $relationship) {
            $product->add(self::buildRelationship($relationship));
        }
        return $product;
    }

    protected static function buildRelationship(string $relationship): BaseRelationship
    {
        list($mark, $lhs, $rhs) = explode('|', $relationship);

        try {
            return match($mark) {
                "OM" => NormalOneToMany::build($lhs, $rhs),
                "POM" => MorphOneToMany::build($lhs, $rhs),
                default => throw new Exception($mark),
            };
        } catch (Exception $e) {
            echo 'Unknown relationship type: ', $e->getMessage(), "\n";
        }
    }

    public function makeProposals(Plan $plan): ProposalList
    {
        $proposals = new ProposalList;

        foreach($this as $relationship) {
            $proposals->add($relationship->makeProposals($plan));
        }

        return $proposals;
    }

    public function add(BaseRelationship|Self $incoming): void
    {
        $this->addItemOrList($incoming);
    }

    public function remove(BaseRelationship|Self $incoming): void
    {
        $this->removeItemOrList($incoming);
    }
}