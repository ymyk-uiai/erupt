<?php

namespace Erupt\Models\Properties\Items;

use Erupt\Models\Properties\BaseProperty;
use Erupt\Models\Values\Items\RelationshipMethodName\Value as RelationshipMethodName;
use Erupt\Models\Values\Items\RelationshipName\Value as RelationshipName;
use Erupt\Models\Values\Items\RelationshipArgs\Value as RelationshipArgs;

class MorphOneToMany extends BaseProperty
{
    public function finish()
    {
        $name = $this->values->get('name');
        $name = preg_replace("/_[a-zA-Z0-9_]+$/", "", $name);
        $capName = ucfirst($name);

        if($this->getFlag('has')) {
            $this->values->update([
                new RelationshipMethodName("${name}s"),
                new RelationshipName('morphMany'),
                new RelationshipArgs("${capName}::class, '${name}able'"),
            ]);
        } else {
            $this->values->update([
                new RelationshipMethodName("${name}"),
                new RelationshipName('morphTo'),
                new RelationshipArgs(""),
            ]);
        }
    }
}