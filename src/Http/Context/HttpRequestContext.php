<?php

namespace inisire\RPC\Http\Context;

use Symfony\Component\HttpFoundation\Request;

interface HttpRequestContext
{
    public function getRequest(): Request;
}