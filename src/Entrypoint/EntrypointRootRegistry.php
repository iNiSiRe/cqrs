<?php

namespace inisire\RPC\Entrypoint;

use Symfony\Component\DependencyInjection\ServiceLocator;

class EntrypointRootRegistry
{
    public function __construct(
        private readonly ServiceLocator $container,
    )
    {
    }

    /**
     * @return iterable<EntrypointRootInterface>
     */
    public function getItems(): iterable
    {
        foreach ($this->container->getProvidedServices() as $id) {
            if (!$this->container->has($id)) {
                continue;
            }

            yield $this->container->get($id);
        }
    }

    public function getRoot(string $name): ?EntrypointRootInterface
    {
        if (!$this->container->has($name)) {
            return null;
        }

        return $this->container->get($name);
    }
}