<?php

namespace inisire\RPC\Http;

interface HttpResultInterface
{
    public function getHttpCode(): int;

    public function getHttpHeaders(): array;
}