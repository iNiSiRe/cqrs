<?php

namespace inisire\RPC\Entrypoint;

use inisire\RPC\Schema as Schema;
use inisire\RPC\Security\Authorization;
use Symfony\Component\Config\Resource\FileResource;

class Loader
{
    public function __construct(
        private readonly EntrypointRootRegistry $rootRegistry,
    )
    {
    }

    public function load(): EntrypointCollection
    {
        $entrypoints = [];
        $resources = [];

        foreach ($this->rootRegistry->getItems() as $root) {
            $reflection = new \ReflectionClass($root);

            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                foreach ($method->getAttributes(Schema\Entrypoint::class) as $attribute) {
                    /**
                     * @var Schema\Entrypoint $entrypoint
                     */
                    $entrypoint = $attribute->newInstance();

                    $authorization = $method->getAttributes(Authorization::class)[0] ?? null;

                    $entrypoints[] = new Entrypoint(
                        $entrypoint->name,
                        $entrypoint->input,
                        $entrypoint->output,
                        $entrypoint->description,
                        $authorization?->newInstance(),
                        $root::class,
                        $method->getName(),
                    );

                    $resources[] = new FileResource($reflection->getFileName());
                }
            }
        }

        return new EntrypointCollection($entrypoints, $resources);
    }
}