<?php

namespace inisire\RPC\Http;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class Redirect implements ResultInterface, HttpResultInterface
{
    public function __construct(
        private readonly string $location,
        private readonly bool $permanent = true
    )
    {
    }

    public function getHttpHeaders(): array
    {
        return [
            'Location' => $this->location
        ];
    }

    public function getHttpCode(): int
    {
        return $this->permanent ? 301 : 307;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}