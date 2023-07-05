<?php

namespace inisire\RPC\Entrypoint;

use Symfony\Component\Config\Resource\FileResource;

class EntrypointCollection
{
    public function __construct(
        private iterable $entrypoints,
        private iterable $resources
    )
    {
    }

    /**
     * @return iterable<Entrypoint>
     */
    public function getEntrypoints(): iterable
    {
        return $this->entrypoints;
    }

    /**
     * @return iterable<FileResource>
     */
    public function getResources(): iterable
    {
        return $this->resources;
    }
}