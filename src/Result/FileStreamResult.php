<?php

namespace inisire\RPC\Result;

use inisire\RPC\Http\HttpResultInterface;
use Psr\Http\Message\StreamInterface;

class FileStreamResult implements ResultInterface, HttpResultInterface
{
    public function __construct(
        private StreamInterface $stream,
        private string $mimeType
    )
    {
    }

    public function getHttpCode(): int
    {
        return 200;
    }

    public function getHttpHeaders(): array
    {
        return [
            'Content-Type' => $this->mimeType
        ];
    }

    public function getOutput(): mixed
    {
        return $this->stream;
    }
}