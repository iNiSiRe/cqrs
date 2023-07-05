<?php

namespace inisire\RPC\Entrypoint;


class Resolver
{
    public function __construct(
        private CachedProvider $provider,
    )
    {
    }

    public function resolve(string $name): ?Entrypoint
    {
        foreach ($this->provider->getEntrypoints() as $entrypoint) {
            if ($name !== $entrypoint->getName()) {
                continue;
            }

            return $entrypoint;
        }
    }
}