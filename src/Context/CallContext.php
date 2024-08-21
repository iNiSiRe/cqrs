<?php

namespace inisire\RPC\Context;

use Symfony\Component\Security\Core\User\UserInterface;

interface CallContext
{
    public function getCaller(): ?UserInterface;
}