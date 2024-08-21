<?php

namespace inisire\RPC\DataObject;

use inisire\DataObject\DataObjectWizard;
use inisire\DataObject\Schema\Type\TObject;

class ObjectTransformer
{
    public function __construct(
        private DataObjectWizard $wizard
    )
    {
    }

    public function collection(iterable $collection, ?string $class = null): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = $this->object($item, $class);
        }

        return $result;
    }

    public function object(object $object, ?string $class = null): array
    {
        return $this->wizard->transform(new TObject($class ?? $object::class), $object);
    }
}