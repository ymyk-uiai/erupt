<?php

namespace Erupt\Files;

use Erupt\Foundation\BaseListItem;
use Erupt\Interfaces\Accessor;
use Erupt\Traits\HandleAccess;
use Erupt\Plans\BasePlan;
use Erupt\Values\Lists\ValueList;
use Erupt\Application as A;
use Erupt\Plans\BasePlan as P;
use Erupt\Relationships\BaseRelationship as R;
use Erupt\Foundation\Initializer as Ini;
use Erupt\Traits\HandleInitialize;
use Erupt\Components\BaseComponent;

abstract class BaseFile extends BaseListItem implements Accessor
{
    use HandleInitialize,
        HandleAccess;

    protected static array $accessKeys = ['f', 'file'];

    protected ValueList $values;

    protected BaseComponent $component;

    //  protected FileMaker $correspondant;
    protected $correspondant;

    public static function build(Ini $ini, P|R $fileMaker): static
    {
        $file = new static($ini);

        $file->values = ValueList::build($ini, implode('|', $file->makeValueList($fileMaker)));

        $file->component = $file->compileComponent();

        $file->correspondant = $fileMaker;

        return $file;
    }

    public function __construct(Ini $ini)
    {
        $this->initialize($ini);
    }

    public function getCorrespondant()
    {
        return $this->correspondant;
    }

    protected function makeValueList(P|R $fileMaker): array
    {
        $path = $this->makePath($fileMaker);
        $fileName = $this->makeFileName($fileMaker);
    
        return [
            "path:$path", 
            "fileName:$fileName",
        ];
    }

    abstract protected function makePath($fileMaker): string;

    abstract protected function makeFileName($fileMaker): string;

    abstract protected function compileComponent(): BaseComponent;

    abstract public function getContent(): string;

    protected function accessAdditionally(string $keys, int $index): Accessor
    {
        return $this->values->access($keys, $index);
    }

    public function getTemplate(): string
    {
        return $this->component->getTemplate();
    }
}