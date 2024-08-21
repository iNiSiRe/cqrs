<?php

namespace inisire\RPC\Context;

use Symfony\Component\Security\Core\User\UserInterface;

class Context implements CallContext
{
    public function __construct(
        private readonly ?UserInterface $caller
    )
    {
    }

    public function getCaller(): ?UserInterface
    {
        return $this->caller;
    }
}