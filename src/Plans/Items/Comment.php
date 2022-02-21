<?php

namespace Erupt\Plans\Items;

use Erupt\Plans\BasePlan;
use Erupt\Models\BaseModel;
use Erupt\Models\Items\Comment as CommentModel;
use Erupt\Interfaces\Migrator;
use Erupt\Proposals\BaseProposal as Proposal;

class Comment extends BasePlan implements Migrator
{
    protected string $name = "comment";

    protected function makeCorrespondingModel(): BaseModel
    {
        return new CommentModel;
    }

    public function getCommand(): string
    {
        return "create_comments_table";
    }

    public function getStatements(): array
    {
        $stmts = [];
        foreach($this->proposals as $proposal) {
            if($this->hasStatement($proposal)) {
                $stmts[] = $this->getStatement($proposal);
            }
        }
        return $stmts;
    }

    protected function hasStatement(Proposal $proposal): bool
    {
        foreach($proposal->getAttrs() as $attr) {
            if($attr->isSchemaCommand()) {
                return true;
            }
        }
        return false;
    }

    protected function getStatement(Proposal $proposal): string
    {
        $modifiers = [];
        foreach($proposal->getAttrs() as $attr) {
            if($attr->isSchemaCommand()) {
                $command = $attr->getSchemaCommand();
            } else if($attr->isSchemaModifier()) {
                $modifiers[] = $attr->getSchemaModifier();
            }
        }
        return implode("->", array_merge([$command], $modifiers));
    }
}