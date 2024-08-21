<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class AccessDenied implements ErrorInterface, ResultInterface, HttpResultInterface
{
    public function getCode(): string
    {
        return '1ec00efb-17f9-6eb6-a1d9-55e2cc62c6ce';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Access denied');
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getHttpCode(): int
    {
        return 403;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}