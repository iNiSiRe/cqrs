<?php

namespace inisire\RPC\DataObject;

use inisire\DataObject\Serializer\ObjectReferenceSerializer;
use Symfony\Component\DependencyInjection\ServiceLocator;

class ObjectReferenceSerializerFactory
{
    public function __construct(
        private ServiceLocator $loaders
    )
    {
    }

    public function create(): ObjectReferenceSerializer
    {
        $loaders = [];
        foreach ($this->loaders->getProvidedServices() as $name) {
            $loaders[] = $this->loaders->get($name);
        }

        return new ObjectReferenceSerializer($loaders);
    }
}