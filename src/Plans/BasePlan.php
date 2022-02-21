<?php

namespace Erupt\Plans;

use Erupt\Foundation\BaseListItem;
use Erupt\Proposals\BaseProposal;
use Erupt\Proposals\Items\Proposal;
use Erupt\Proposals\Lists\ProposalList;
use Erupt\Relationships\Lists\RelationshipList;
use Erupt\Models\BaseModel;

abstract class BasePlan extends BaseListItem
{
    protected ProposalList $proposals;

    public function __construct()
    {
        $this->proposals = new ProposalList;
    }

    public static function build(array $plan, RelationshipList $relationships): static
    {
        $product = new static;

        foreach ($plan["props"] as $prop) {
            $product->addProposal(Proposal::build($prop));
        }

        $product->addProposals($relationships->makeProposals($product));

        return $product;
    }

    public function makeModel(): BaseModel
    {
        $product = $this->makeCorrespondingModel();

        foreach($this->proposals as $proposal) {
            $product->getProperties()->add($proposal->makeProperties());
        }

        return $product;
    }

    public function addProposal(Proposal $proposal): void
    {
        $this->proposals->add($proposal);
    }

    protected function addProposals(ProposalList $proposals): void
    {
        $this->proposals->add($proposals);
    }

    public function getName(): string
    {
        return $this->name;
    }
}