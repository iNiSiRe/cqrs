<?php

namespace inisire\RPC\DataObject;

use Symfony\Component\DependencyInjection\ServiceLocator;

class DataSerializerProvider extends \inisire\DataObject\DataSerializerProvider
{
    public function __construct(
        private ServiceLocator $serializers
    )
    {
//        Basic serializers:
//        new ScalarSerializer(),
//        new DictionarySerializer(),
//        new DateTimeSerializer(),
//        new FileSerializer(),
//        new ObjectSerializer($provider),
//        new CollectionSerializer($provider),
//        new ObjectReferenceSerializer($loaders),
//        new UuidSerializer()

        $serializers = [];

        foreach ($this->serializers->getProvidedServices() as $name) {
            $serializers[] = $this->serializers->get($name);
        }
        
        parent::__construct($serializers);
    }
}