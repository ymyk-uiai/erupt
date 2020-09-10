<?php

namespace Erupt\Relationships\Lists\Relationships;

use Erupt\Abstracts\Foundations\BaseList;
use Erupt\Relationships\Constructors\Lists\Relationships\RelationshipListConstructor;

class RelationshipList extends BaseList
{
    public function __construct()
    {
        //
    }

    public static function build($config)
    {
        return RelationshipListConstructor::build($config);
    }

    public function add($relationship)
    {
        parent::add($relationship);
    }

    public function remove($relationship_s)
    {
        parent::remove($relationship_s);
    }
}