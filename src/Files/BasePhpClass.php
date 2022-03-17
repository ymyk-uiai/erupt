<?php

namespace Erupt\Files;

use Erupt\Plans\BasePlan as P;
use Erupt\Relationships\BaseRelationship as R;
use Erupt\Interfaces\PhpClassFile;
use Erupt\Language\EruptLang;
use Erupt\Language\Scope;

abstract class BasePhpClass extends BaseFile implements PhpClassFile
{
    protected function makeValueList(P|R $fileMaker): array
    {
        $className = $this->makeClassName($fileMaker);
        $shortName = $this->makeShortName($fileMaker);
        $namespace = $this->makeNamespace($fileMaker);
    
        return array_merge(parent::makeValueList($fileMaker), [
            "className:$className",
            "shortName:$shortName",
            "namespace:$namespace",
        ]);
    }

    abstract protected function makeClassName($fileMaker): string;

    abstract protected function makeShortName($fileMaker): string;

    abstract protected function makeNamespace($fileMaker): string;

    public function getContent(): string
    {
        $lang = new EruptLang($this->app);

        $scope = $this->getScope();

        return $lang->exec($this, $scope);
    }

    protected function getScope(): Scope
    {
        return Scope::init([
            'app' => $this->app,
            'model' => $this->app->getModel($this->correspondant->getClassSymbol()),
            'auth' => $this->app->getModel('User'),
        ]);
    }
}