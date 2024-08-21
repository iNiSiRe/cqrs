<?php

namespace inisire\RPC\Result;

use inisire\RPC\Http\Cache\CacheControl;
use inisire\RPC\Http\Cache\Expires;
use inisire\RPC\Http\HttpResultInterface;

class CachedResult implements ResultInterface, HttpResultInterface, MutableOutputInterface
{
    public function __construct(
        private mixed $output,
        private readonly ?CacheControl $cacheControl = null,
        private readonly ?Expires $expires = null
    )
    {
    }

    public function getHttpCode(): int
    {
        return 200;
    }

    public function getHttpHeaders(): array
    {
        $headers = [];

        if ($this->cacheControl) {
            $headers['Cache-Control'] = $this->cacheControl->toString();
        }

        if ($this->expires) {
            $headers['Expires'] = $this->expires->toString();
        }

        return $headers;
    }

    public function getOutput(): mixed
    {
        return $this->output;
    }

    public function setOutput(mixed $output)
    {
        $this->output = $output;
    }
}
