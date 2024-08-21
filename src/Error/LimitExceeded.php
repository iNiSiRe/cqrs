<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class LimitExceeded implements ErrorInterface, ResultInterface, HttpResultInterface
{
    private ?int $used;
    private ?int $limit;

    public function __construct(int $used = null, int $limit = null)
    {
        $this->used = $used;
        $this->limit = $limit;
    }

    public function getCode(): string
    {
        return '1ec0448d-4ca0-680a-b256-b91e52028005';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Too many requests');
    }

    public function getHttpCode(): int
    {
        return 429;
    }

    public function getHttpHeaders(): array
    {
        $headers = [];

        if ($this->limit !== null && $this->used !== null) {
            $headers['X-Rate-Limit-Remaining'] = $this->limit - $this->used;
        }

        if ($this->limit !== null) {
            $headers['X-Rate-Limit-Limit'] = $this->limit;
        }

        return $headers;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}