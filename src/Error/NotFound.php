<?php

namespace inisire\RPC\Error;


use inisire\DataObject\Error\ErrorMessage;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;

class NotFound implements ErrorInterface, ResultInterface, HttpResultInterface
{
    public function getCode(): string
    {
        return '1ec00ef8-d2f8-6116-a101-b969ba46bac1';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Not found');
    }

    public function getHttpCode(): int
    {
        return 404;
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getOutput(): mixed
    {
        return null;
    }
}