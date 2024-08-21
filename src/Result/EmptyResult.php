<?php

namespace inisire\RPC\Result;


use inisire\RPC\Http\HttpResultInterface;

class EmptyResult extends Result implements HttpResultInterface
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public function getHttpCode(): int
    {
        return 204;
    }

    public function getHttpHeaders(): array
    {
        return [];
    }
}