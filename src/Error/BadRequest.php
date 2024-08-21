<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class BadRequest implements ErrorInterface, ResultInterface, HttpResultInterface
{
    public function getCode(): string
    {
        return '1ec03457-6a38-6f5c-a57e-57277a6c17f6';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Bad request');
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getHttpCode(): int
    {
        return 400;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}