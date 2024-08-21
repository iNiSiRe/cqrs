<?php

namespace inisire\RPC\Http\Context;

use inisire\RPC\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class RequestContext extends Context implements HttpRequestContext
{
    public function __construct(
        private readonly Request $request,
        ?UserInterface            $caller,
    )
    {
        parent::__construct($caller);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}